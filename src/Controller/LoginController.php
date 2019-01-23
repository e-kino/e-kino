<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", methods={"POST"}, name="ekino_login")
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        var_dump($request);
        //todo TB git test
        //todo get json from request
        //todo create new session
        /*
         *  $credentials = [
         
            'email' => $request->request->get('login'),
            'password' => $request->request->get('password'),
            
        ];
         * print_r($credentials);
         */
        //$request->getContent();
        $data = json_decode($request->getContent(), true);
        echo $data;
        //$this->setSession($userData);
         return new JsonResponse([
            'message' => "logowanie sie powiodlo"
        ]);
    }

    /**
     * @Route("/logout", methods={"POST"}, name="ekino_logout")
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        //todo TB
        //todo destroy session
        return new JsonResponse([
            'message' => "wylogowanie sie powidolo"
        ]);
    }
    protected function setSession($userData)
    {
        // SET SESSION 
        $this->get('session')->set('loginUserId', $userData['id']);
        $this->get('session')->set('loginUserEmail', $userData['email']);
        $this->get('session')->set('loginUserRole', $userData['role']);
    }
    /**
     * @Route("/login", methods={"GET"}, name="ekino_login_get")
     * @return JsonResponse
     */
    public function loginGet()
    {
        return new JsonResponse(['error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]]);
    }
    /**
     * @Route("/logout", methods={"GET"}, name="ekino_logout_get")
     * @return JsonResponse
     */
    public function logoutGet()
    {
        return new JsonResponse(['error' => [
                'code' => 405,
                'message' => "Method not allowed you ugly buster"
            ]]);
    }
    /**
     * @Route("/loginpage", methods={"GET"}, name="ekino_loginpage")
     */
    public function loginPage()
    {
        return new Response(
            '<html><body><p>FORM</p>
        <form name="myForm" action="http://localhost:8070/login" method="POST">
          Login: <input type="text" name="login"><br>
          Password: <input type="password" name="password"><br>
          
          <input type="button" value="Submit" onclick="validateForm();" />
        </form></body></html>'
        );
    }
}
?>
 <script>
function validateForm() {
console.log('validateForm');

	var obj = new Object();
   obj.login = document.forms["myForm"]["login"].value;
   obj.password  = document.forms["myForm"]["password"].value;

   var jsonString= JSON.stringify(obj);
	console.log(jsonString);
	var xhttp = new XMLHttpRequest();
	
	
	xhttp.onreadystatechange = function()
	{
		console.log(this.readyState);
                console.log(this.status);
		if (this.readyState == 4 && this.status == 200)
		{
		   // Action to be performed when the document is read;
		   console.log('send');
                   console.log('Response text  - '+xhttp.responseText);
                   console.log('Response XML  - '+xhttp.responseXML);
		}
	};
        xhttp.open("POST", "http://localhost:8070/login", true);
         xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send(jsonString);
}
</script>