<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.3/angular.js"></script>

<style>
    .loginContainer {
        text-align: center;
        width: 400px;
        box-shadow: 0px 0px 5px 0px #abc; 
        border: 0px solid black;
    }
    input[type=text] {
        border: none;
        font-size: 15px;
        width: 80%;
        border-bottom: 1px solid black;
        margin-bottom: 10px;
    }
    
    input[type=password] {
        border: none;
        font-size: 15px;
        width: 80%;
        border-bottom: 1px solid black;
        margin-bottom: 10px;
    }
    
    .register {
        background-color: crimson;
        width: 50%;
        margin-bottom: 5px;
        height: 25px;
        border: none;
    }
    
    .error {
        color: red;
        margin-bottom: 5px;
    }

    h2 {
        background-color: crimson;
        border-bottom: 2px solid black;
        text-shadow: 2px 0 0 #abc, -2px 0 0 #abc, 0 2px 0 #abc, 0 -2px 0 #abc, 1px 1px #abc, -1px -1px 0 #abc, 1px -1px 0 #abc, -1px 1px 0 #abc;
        margin: 0px;
        margin-bottom: 10px;
    }
</style>
    
<script>
var app = angular.module('myApp', []);

app.directive('nxEqualEx', function() {
    return {
        require: 'ngModel',
        link: function (scope, elem, attrs, model) {
            if (!attrs.nxEqualEx) {
                console.error('nxEqualEx expects a model as an argument!');
                return;
            }
            scope.$watch(attrs.nxEqualEx, function (value) {
                // Only compare values if the second ctrl has a value.
                if (model.$viewValue !== undefined && model.$viewValue !== '') {
                    model.$setValidity('nxEqualEx', value === model.$viewValue);
                }
            });
            model.$parsers.push(function (value) {
                // Mute the nxEqual error if the second ctrl is empty.
                if (value === undefined || value === '') {
                    model.$setValidity('nxEqualEx', true);
                    return value;
                }
                var isValid = value === scope.$eval(attrs.nxEqualEx);
                model.$setValidity('nxEqualEx', isValid);
                return isValid ? value : undefined;
            });
        }
    };
});

function Ctrl($scope) {} 
</script>

  
</head>

<body ng-app="myApp">
  <div class="loginContainer" ng-controller='Ctrl'>
    <h2> User Registration </h2>
    <form action="google.ca" method="post" name="formEx">
        <input type="text" name="username" placeholder="Username" oninvalid="this.setCustomValidity('Please Enter valid Username')" oninput="setCustomValidity('')" required><br>
        <input ng-model="loginEx.password" type="password" name="password" placeholder="Password" oninvalid="this.setCustomValidity('Please Enter valid Password')" oninput="setCustomValidity('')"required><br>
        <div class="error" ng-show="formEx.password.$error.required"></div>
        <input ng-model="loginEx.verify" type="password" name="verify" placeholder="Confirm Password" required oninvalid="this.setCustomValidity('Please Confirm your password')" oninput="setCustomValidity('')" nx-equal-ex="loginEx.password"><br>
        <div class="error" ng-show="formEx.verify.$error.required"></div>
        <div class="error" ng-show="formEx.verify.$error.nxEqualEx">Please ensure passwords match!</div>
        <button class="register"> Register </button>
    </form>
</div>

  
</body>

</html>