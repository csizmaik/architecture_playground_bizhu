_**Biztositas.hu** Guidelines_

**Managing Tasks (services)**

* Internal Managing Tasks can get External Managing Tasks and Internal Managing Tasks only through DI.

        // bad
        namespace services/auth;
        
        use services/user/UserService;
        
        class AuthService {
        
            private $userService;
            
            public function __constructor() {
                $this->userService = new UserService();
            }
        
            public function authenticate() {
                $this->userService->getAll();
            }
        }
        
        
        // bad, can not use the container module in a Managing Tasks
        namespace services/auth;
        
        use infrastructure/DIContainer/ContainerBuilder;
        
        class AuthService {
        
            private $userService;
        
            public function __constructor() {
                $DIContainer = ContainerBuilder::createContainer();
                $this->userService = $DIContainer->get(’user_service’);
            }
        
            public function authenticate() {
                $this->userService->getAll();
            }
        
        }
        
        
        // good
        class AuthService {
        
            private $userService;
        
            public function __constructor($userService) {
                $this->userService = $userService;
            }
        
            public function authenticate() {
                $this->userService->getAll();
            }
        }
* Internal Managing Tasks can get Executing Task only through module system from its own directory, and the Executing task responsibility should be related to the Internal Managing Tasks.
    
        // bad - use ET from different module(service)
        namespace services/user;
        
        use services/contacts/EmailFormatValidator;
        
        class UserService {
            private $userRepository;
            
            public function __construct($userRepository) {
                $this->userRepository = $userRepository;
            }
            
            public function validateCredential($loginName, $password)
            {
                EmailFormatValidator::isValid($loginName);
                $user = $this->userRepository->getByLoginName($loginName);
                $user->validateCredential($password);
            }
        }
        
        // good - use ET from same module(service)
        namespace services/user;
        
        class UserService {
            private $userRepository;
                    
            public function __construct($userRepository) {
                $this->userRepository = $userRepository;
            }
                    
            public function validateCredential($loginName, $password)
            {
                LoginNameValidator::isValid($loginName);
                $user = $this->userRepository->getByLoginName($loginName);
                $user->validateCredential($password);
            }
        }
        
        // good - use ET from a library
        namespace services/user;
                
        use lib/validators/EmailFormatValidator;
        
        class UserService {
            private $userRepository;
            
            public function __construct($userRepository) {
                $this->userRepository = $userRepository;
            }
            
            public function validateCredential($loginName, $password)
            {
                EmailFormatValidator::isValid($loginName);
                $user = $this->userRepository->getByLoginName($loginName);
                $user->validateCredential($password);
            }
        }
        
* External Managing Tasks can get External Managing Tasks only through DI.
* You cannot pass a Managing Task.

        // bad
        $customerService->getCustomers($userService);

        // bad
        $tools->calculateCustomerPrice($customerService);
        
* In Managing Tasks you should not use control structures and modify, mutate state.

      // bad
      $user = $userService->getUser();
      if ($user->type === null) {
        $user->type = 'developer';
      }

      // good
      $user = $userService->getUser();
      $initializedUser = $tools->initUser($user);
        
**Executing Tasks (modules)**

* An Executing task can import modules from ./ or using the module system. If you want to use a public module element from another module then you should promote it to a service.

        // bad - use ET from different module(service)
        namespace services/user;
                
        use services/contacts/EmailFormatValidator;
                
        class LoginNameValidator {
            public static function isValidLoginName($loginName)
            {
                return (strlen($loginName) > 0 && EmailFormatValidator::isValid($loginName));
            }
        }
                
        // good - use ET from same module(service)
        namespace services/user;
                        
        class LoginNameValidator {
            public static function isValidLoginName($loginName)
            {
                return (strlen($loginName) > 0 && LoginFormatValidator::isValid($loginName));
            }
        }
                
        // good - use ET from a library
        namespace services/user;
                
        use lib/validators/EmailFormatValidator;
                               
        class LoginNameValidator {
            public static function isValidLoginName($loginName)
            {
                return (strlen($loginName) > 0 && EmailFormatValidator::isValid($loginName));
            }
        }

* An Exnecuting task can not use the DI container.

        // bad
        function calculatePrice($id, $discount) {
          $price = $container::getInstance()->get('priceService')->getPriceById(id);
          return $price * $discount;
        }
        
        // good
        function calculatePrice($price, $discount) {
          return $price * $discount;
        }
        
* An Executing task can use control stuctures and store internal state in the function scope or in the class scope.
        
        class User {
            private $login;
            private $password;
            private $unsuccessCredentialValidationNum;
            
            public function __construct($login, $password) {
                $this->login = $login;
                $this->password = $password;
                $this->unsuccessCredentialValidationNum = 0;
            }
            
            public function validateCredential($password) {
                if ($password == $this->password) {
                    return true;
                } else {
                    $this->unsuccessCredentialValidationNum++;
                    return false;
                }
            }
        }

