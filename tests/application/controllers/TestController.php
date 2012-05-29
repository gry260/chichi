<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {    	
        /* Initialize action controller here */          
    }
	
	


    public function indexAction()
    {
	
        // action body
		
		$frontendOptions = array(
  		 'lifetime' => 7200, // cache lifetime of 2 hours
   		 'automatic_serialization' => true );
		
		$backendOptions = array('cache_dir' => './tmp/' // Directory where to put the cache files
		);
		
		$cache = Zend_Cache::factory('Core',
                             'File',
                             $frontendOptions,
                             $backendOptions);
							 
		$test = new UserControllerTest();
		$test->setUp();
		
		
	
    }
}


class UserControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->frontController->registerPlugin(
            new Bugapp_Plugin_Initialize('test')
        );
    }

    public function testCallingControllerWithoutActionShouldPullFromIndexAction()
    {
        $this->dispatch('/user');
        $this->assertResponseCode(200);
        $this->assertController('user');
        $this->assertAction('index');
    }

    public function testIndexActionShouldContainLoginForm()
    {
        $this->dispatch('/user');
        $this->assertResponseCode(200);
        $this->assertSelect('form#login');
    }

    public function testValidLoginShouldInitializeAuthSessionAndRedirectToProfilePage()
    {
        $this->request
             ->setMethod('POST')
             ->setPost(array(
                 'username' => 'foobar',
                 'password' => 'foobar'
             ));
        $this->dispatch('/user/login');
        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->assertRedirectTo('/user/view');
    }
}

