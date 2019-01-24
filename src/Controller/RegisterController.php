<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegisterController extends AbstractController
{
    const email='email';
    const password='password';
    /**
     * @Route("/register", methods={"POST"}, name="ekino_register")
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $err = 0;
        $message = 'Użytkownik został zarejestrowany';
        $userData = json_decode($request->getContent(), true);
        if (!$this->validFields($userData))
        {
            $err = 1;
            $message = "Przekazano nieprawidłowe pola z formularza.";
        };
        if($err===0)
        {
            if (!$this->isEmpty($userData['email'], $userData['password']))
            {
                $err = 1;
                $message = "Nie uzupełniono wszystkich wymaganych pól";
            }; 
        }
         if ($err === 0) {
            if (!$this->checkUserEmail($userData['email'])) {
                $err = 1;
                $message = "Nieprawidłowy adres email";
            }
        }
        if ($err === 0) {
            if (!$this->getUserByEmail($userData['email'])) {
                $err = 1;
                $message = "Użytkownik o podanym adresie email już istnieje";
            }
        }
        if ($err === 0) {
            if (!$this->addUserToDb($userData['email'],$userData['password'])) {
                $err = 1;
                $message = "Nie udało się załozyć konta. Powiadom administratora.";
            }
        }
        return new JsonResponse([
            'error' => $err,
            'message' => $message
        ]);
    }
    /**
     * @Route("/register", methods={"GET"}, name="ekino_register_get")
     * @return JsonResponse
     */
    public function registerGet()
    {
        return new JsonResponse([
            'error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]
        ]);
    }
    protected function isEmpty($email, $pass)
    {
        if (trim($email) === '' || trim($pass) === '')
        {
            return false;
        }
        return true;
    }
    protected function validFields($userData)
    {
        if(!array_key_exists(self::email,$userData) || !array_key_exists(self::password,$userData))
        {
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
    protected function getUserByEmail($email)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->getDoctrine()
                                ->getRepository(User::class);

        $user = $userRepository->findByEmail($email);
        return is_null($user);
    }
    protected function addUserToDb($email,$pass)
    {
        $passEncode = password_hash($pass, PASSWORD_BCRYPT);
        $entityManager = $this->getDoctrine()->getManager();
        $date=new \DateTime("now");
        try{
            $user = new User();
            #print_r($user);
            $user->setEmail($email);
            $user->setPassword($passEncode);
            $user->setRoleId(1);
            $user->setDateAdd($date);
            $entityManager->persist($user);
  
            $entityManager->flush();
        }
        catch (\Doctrine\ORM\EntityNotFoundException $exception)
        {
            #echo($exception->getMessage());
            return false;
        }
        return true;
    }
    /**
     * @Route("/registerpage", methods={"GET"}, name="ekino_registerpage")
     */
    public function registerPage()
    {
        return new Response(
            '<html><body><p>FORM REGISTER</p>
        <form name="myForm" action="http://localhost:8070/register" method="POST">
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
        xhttp.open("POST", "http://localhost:8070/register", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(jsonString);
}
</script>'
        );
    }
}
