_**Biztositas.hu** Guidelines_

**Managing Tasks (services)**

* Internal Managing Tasks can get External Managing Tasks and Internal Managing Tasks only through DI.

        // bad
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
        class AuthService {
        
            private $userService;
        
            public function __constructor($DIContainer) {
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
    
        // bad
        const tools = require(../../internal/messages/tools);

        // good
        const tools = require(./tools);
        
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

        // bad
        const tools = require('../../internal/messages/tools');
        
        // good
        const _ = require(lodash);
        const tools = require('./tools');
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
        
* An Executing task can use control stuctures and store internal state in the function scope.
        
        // good
        function execute($elements) {
          [head, ...tail] = elements;
          const result = head();
          if (result) {
            return result
          }
          execute(tail);
        }

