<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    const email='email';
    const password='password';
    /**
     * @Route("/login", methods={"POST"}, name="ekino_login")
     * @param Request $request
     * @return JsonResponse
     * @throws \LogicException
     */
    public function login(Request $request)
    {
        $err = 0;
        $message = 'Logowanie się powiodło';
        //echo ("Recive Request content - ".$request->getContent()."\n");
        $userData = json_decode($request->getContent(), true);
        //print_r($userData);
        if (!$this->validFields($userData)){
            $err = 1;
            $message = "Przekazano nieprawidłowe pola z formularza.";
        };
        if ($err === 0){
            if (!$this->isEmpty($userData['email'], $userData['password'])) {
                $err = 1;
                $message = "Nie uzupełniono wszystkich pól";
            };
        }
        if ($err === 0) {
//            echo "check email\n";
            if (!$this->checkUserEmail($userData['email'])) {
                $err = 1;
                $message = "Nie prawidłowy adres email";
            }
        }
        if ($err === 0) {
//            echo "check in db\n";
            if (!$this->checkUserInDb($userData['email'], $userData['password'])) {
                $err = 1;
                $message = "Nie prawidłowe dane logowania";
            }
        }
        $this->setSession($userData['email']);
        return new JsonResponse([
            'error' => $err,
            'message' => $message
        ]);
    }
    protected function validFields($userData)
    {
        if(!array_key_exists(self::email,$userData) || !array_key_exists(self::password,$userData)){
            return false;
        }
        return true;
    }
    protected function isEmpty($email, $pass)
    {
        if (trim($email) === '' || trim($pass) === '') {
            return false;
        }
        return true;
    }

    protected function checkUserEmail($email)
    {
        $regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/";
        $email = strtolower($email);
        return preg_match($regex, $email);
    }

    protected function checkUserInDb($email, $pass)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        /** @var User $user */
        $user = $userRepository->findByEmail($email);

        return !is_null($user) && password_verify($pass, $user->getPassword());
    }

    protected function setSession($userEmail)
    {
        // SET SESSION
        //$this->get('session')->set('loginUserId', $userData['id']);
        $this->get('session')->set('loginUserEmail', $userEmail);
        //echo "SESSION - ".$this->get('session')->get('loginUserEmail')."\n";
    }

    /**
     * @Route("/logout", methods={"POST"}, name="ekino_logout")
     * @return JsonResponse
     */
    public function logout()
    {
        session_start();
        session_destroy();

        return new JsonResponse([
            'message' => "Wylogowanie się powidło"
        ]);
    }

    /**
     * @Route("/login", methods={"GET"}, name="ekino_login_get")
     * @return JsonResponse
     */
    public function loginGet()
    {
        return new JsonResponse([
            'error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]
        ]);
    }

    /**
     * @Route("/logout", methods={"GET"}, name="ekino_logout_get")
     * @return JsonResponse
     */
    public function logoutGet()
    {
        return new JsonResponse([
            'error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]
        ]);
    }

    /**
     * @Route("/loginpage", methods={"GET"}, name="ekino_loginpage")
     */
    public function loginPage()
    {
        return new Response(
            '<html><body><p>FORM</p>
        <form name="myForm" action="http://localhost:8070/login" method="POST">
          Email: <input type="text" name="email"><br>
          Password: <input type="password" name="password"><br>
          <input type="button" value="Submit" onclick="validateForm();" />
        </form></body></html><p id=\'response\'>aa</p>
        <script>
function validateForm() {
console.log(\'validateForm\');
    var responseData;
    var jsonData;
    var obj = new Object();
   obj.email = document.forms["myForm"]["email"].value;
   obj.password  = document.forms["myForm"]["password"].value;
   var jsonString= JSON.stringify(obj);
	console.log(jsonString);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
                   responseData=xhttp.responseText
                   console.log(\'---Response text  ---\');
                   jsonData = JSON.parse(responseData);
                   console.log(responseData);
                   console.log(jsonData[\'message\']);
                   document.getElementById(\'response\').innerText=jsonData[\'message\'];
		}
	};
        xhttp.open("POST", "http://localhost:8070/login", true);
         xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(jsonString);
}
</script>'
        );
    }
}

