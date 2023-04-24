<?php

include("connection.php");
error_reporting(0);
?>

<!doctype html>
<html><!-- InstanceBegin template="/Templates/basic-bootstrap.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- InstanceBeginEditable name="doctitle" -->
<title>360 Evaluation | Create Evaluation</title>
<!-- InstanceEndEditable -->
<link rel="icon" type="image/png" href="images/logo48.png" />
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
<script type="text/javascript" src="third-party/jQuery/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="third-party/jQuery/jquery.cookie-1.4.1.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-animate.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-route.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-touch.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-cookies.min.js"></script>
<script type="text/javascript" src="third-party/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/directive.js"></script>
<script type="text/javascript" src="js/service.js"></script>
<script type="text/javascript" src="third-party/angularjs-ui/UI-Bootstrap/ui-bootstrap-tpls-1.3.2.js"></script>
<script type="text/javascript" src="third-party/Blob.js-master/Blob.js"></script>
<script type="text/javascript" src="third-party/FileSaver.js/FileSaver.js-1.3.2/FileSaver.min.js"></script>
<script src="third-party/ng-file-upload-12.2.12/demo/src/main/webapp/js/ng-file-upload-shim.js"></script>
<script src="third-party/ng-file-upload-12.2.12/demo/src/main/webapp/js/ng-file-upload.js"></script>
<!-- InstanceBeginEditable name="head" -->
<script src="js/menu.js"></script>
<script>
// jQuery
$(function() {
	
});
</script>
<script>
"use strict";
app.run(function ($rootScope, $log, Security) {
	console.log("app.run at local page");
	//Security.GoToMenuIfSessionExists();
	Security.RequiresAuthorization();
});


app.controller('createDepartmentController', ['$scope', 'Security', 'MessageService', function ($scope, Security, MessageService, $rootScope) {
	$scope.directiveScopeDict = {};
	$scope.directiveCtrlDict = {};
    
	function Initialize(){
		var entryForm = {};
		
		$scope.entryForm = entryForm;
	}
	Initialize();
	
	$scope.EventListener = function(scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried EventListener()");
		var prgmID = scope.programId;
		if($scope.directiveScopeDict[prgmID] == null || typeof($scope.directiveScopeDict[prgmID]) == "undefined"){
		  $scope.directiveScopeDict[prgmID] = scope;
		  $scope.directiveCtrlDict[prgmID] = controller;
		}
		
		//http://api.jquery.com/Types/#Event
		//The standard events in the Document Object Model are:
		// blur, focus, load, resize, scroll, unload, beforeunload,
		// click, dblclick, mousedown, mouseup, mousemove, mouseover, mouseout, mouseenter, mouseleave,
		// change, select, submit, keydown, keypress, and keyup.
		iElement.ready(function() {
			
		})
	}
	
	$scope.SetDefaultValue = function(scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried SetDefaultValue()");
		
		//controller.ngModel.gender = "M";
	}
	
	$scope.StatusChange = function(fieldName, newValue, newObj, scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried StatusChange()");
//		console.log(fieldName);
//		console.log(newValue);
		
		if(fieldName == "EvaluationCode")
			newObj.EvaluationCode = newObj.EvaluationCode.toUpperCase(); 
	}
	
	$scope.ValidateBuffer = function(scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried ValidateBuffer()");
		
		var isValid = true;
		var record = controller.ngModel;
		var msg = [];
		
		var startDate = record.StartDate;
		var endDate = record.EndDate;
		var probationEndDate = record.ProbationEndDate;
		var reminderStartDate = record.ReminderStartDate;
		var reminderEndDate = record.ReminderEndDate;
		
		if(!startDate){
			isValid = false;
			msg.push("Start Date is invalid");
		}
		
		if(!endDate){
			isValid = false;
			msg.push("End Date is invalid");
		}
		
		if(!probationEndDate){
			isValid = false;
			msg.push("Probation End Date is invalid");
		}
		
		if(!reminderStartDate){
			isValid = false;
			msg.push("Reminder Start Date is invalid");
		}
		
		if(!reminderEndDate){
			isValid = false;
			msg.push("Reminder End Date is invalid");
		}
		
		// validate startDate, endDate
		if(startDate.getTime() > endDate.getTime()) { 
			isValid = false;
			msg.push("Start Date cannot after than End Date");
		}
		// validate reminderStartDate, reminderEndDate
		if(reminderStartDate.getTime() > reminderEndDate.getTime()) { 
			isValid = false;
			msg.push("Reminder Start Date cannot after than Reminder End Date");
		}
		
		// validate reminder date period should inside of the evaluation period
		if(reminderStartDate < startDate || reminderEndDate > endDate){
			isValid = false;
			msg.push("Reminder Date Period should inside of the Evaluation Period");
		}
		
		// validate probation end date should on or before the evaluation start date
		if(probationEndDate > startDate){
			isValid = false;
			msg.push("Probation End Date should on or before the Evaluation Start Date");
		}
		
		if(!isValid){
			MessageService.setMsg(msg);
		}

        return isValid;
	}

    $scope.CustomSelectedToRecord = function(sRecord, rowScope, scope, iElement, controller){
        console.log("<"+iElement[0].tagName+">" +" Directive overried CustomPointedToRecord()");
        $scope.amendForm = sRecord;
        $scope.deleteForm = sRecord;
    }

    $scope.CustomSubmitDataResult = function(responseObj, httpStatusCode, scope, element, attrs, ctrl){
        var prgmID = scope.programId;
//        if(prgmID == "es01dp"){
//          $scope.directiveScopeDict["ew01dp"].ClearNRefreshData();
//        }
    }
}]);
</script>
<!-- InstanceEndEditable -->
</head>

<body ng-app="myApp">
<div id="top">
  <div id="topBar"> <!-- InstanceBeginEditable name="topbar" --> <!-- InstanceEndEditable --> </div>
</div>
<!-- header start -->
<nav class="navbar navbar-default" role="navigation">
  <div class="container">
  <!-- InstanceBeginEditable name="header" -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">360° Evaluation System</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav" id="bs-example-navbar-collapse-1">
        <li><a href="main-menu.html">Home <span class="fa fa-home fa-lg"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evaluation <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header menu-admin">Evaluation Master</li>
            <li class="menu-admin"><a href="create-evaluation.html">Create</a></li>
            <li class="menu-admin"><a href="amend-evaluation.html">Amend</a></li>
            <li class="menu-admin"><a href="delete-evaluation.html">Delete</a></li>
            <li role="separator" class="divider menu-admin"></li>
            <li class="dropdown-header">Evaluation Operation</li>
            <li class="menu-admin"><a href="process-questionnaire-design.html">Questionnaire Design</a></li>
            <li class="menu-admin"><a href="process-gen-eva-proposal.html">Generate Evaluation Proposal</a></li>
            <li class="menu-admin"><a href="evaluation-proposal-entry.html">View Evaluation Proposal</a></li>
            <li><a href="create-evaluation-entry.html">360 Degree Evaluation Entry</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Report</li>
            <li><a href="Individual-report.html">Individual Report(Self)</a></li>
          </ul>
        </li>
        <li class="dropdown menu-admin">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Staff <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Staff Profile</li>
            <li><a href="create-staff-profile.html">Create</a></li>
            <li><a href="amend-staff-profile.html">Amend</a></li>
            <li><a href="delete-staff-profile.html">Delete</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Utility</li>
            <li><a href="import-export-staff.html">Staff Import/Export</a></li>
          </ul>
        </li>
        <li class="dropdown menu-admin">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Master <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Utility</li>
            <li><a href="import-export-master.html">Master Import/Export</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Vendor</li>
            <li><a href="create-vendor.html">Create</a></li>
            <li><a href="amend-vendor.html">Amend</a></li>
            <li><a href="delete-vendor.html">Delete</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Department</li>
            <li><a href="create-department.html">Create</a></li>
            <li><a href="amend-department.html">Amend</a></li>
            <li><a href="delete-department.html">Delete</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Staff Grade</li>
            <li><a href="create-staffgrade.html">Create</a></li>
            <li><a href="amend-staffgrade.html">Amend</a></li>
            <li><a href="delete-staffgrade.html">Delete</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Position</li>
            <li><a href="create-position.html">Create</a></li>
            <li><a href="amend-position.html">Amend</a></li>
            <li><a href="delete-position.html">Delete</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="personal-profile.html">Personal profile <span class="fa fa-user fa-lg"></span></a></li>
        <li><a href="#" logout>Logout <span class="fa fa-sign-out fa-lg"></span></a></li>
      </ul>
    </div>
  <!-- InstanceEndEditable -->
  </div>
</nav>
<!-- header end -->
<div class="container">
<!-- InstanceBeginEditable name="page-header" -->
<h1 class="page-header">Create Evaluation</h1>
<!-- InstanceEndEditable -->
<!-- site position start --> 
<!-- InstanceBeginEditable name="position" -->
<div id="site_position">
    <ol class="breadcrumb">
      <li><a href="main-menu.html">Home</a></li>
    </ol>
</div>
<!-- InstanceEndEditable --> 
</div>
<!-- site position end --> 
<div class="container">
<!-- InstanceBeginEditable name="intro" -->
<div ng-controller="mainCtrl">
	<process ng-model="processModel" program-id="ei01wu"></process>
</div>
<div ng-controller="createDepartmentController as createDeptCtrl" style="max-width: 750px;">
        <div class="panel panel-default">
          <div class="panel-heading">Process Message</div>
          <div class="panel-body">
            <message ng-model="processMsg" auto-close>
              <div class="well well-sm" ng-if="msgCtrl.ngModel.length > 0">
                <div ng-repeat="dspMsg in msgCtrl.ngModel track by $index" ng-bind="dspMsg"></div>
              </div>
            </message>
          </div>
        </div>
	<h3>Create Evaluation</h3>
    <entry ng-model="entryForm" program-id="es01ev" edit-mode="create">
		<form ng-submit="SubmitData()" action ="" method="POST">
			<fieldset>
                <div class="form-group">
                    <label for="inEvaCode">Evaluation Code</label>
                    <input type="text" class="form-control" id="inEvaCode" name="evcode"ng-model="entryForm.EvaluationCode">
                </div>
                <div class="form-group">
                    <label for="inputDesc">Description</label>
                    <textarea class="form-control" id="inputDesc" name="des" ng-model="entryForm.Description"></textarea>
                </div>
                <div class="form-group">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="inputStart">Start Date</label>
                        <input type="date" class="form-control" id="inputStart" name="sdt" ng-model="entryForm.StartDate">
                    </div>
                    <div class="form-group">
                        <label for="intputEnd">End Date</label>
                        <input type="date" class="form-control" id="intputEnd" name="edt" ng-model="entryForm.EndDate">
                    </div>
                </div>
                </div>
                <div class="form-group">
                <div class="form-inline">
                    <label for="inputProEnd">Probation End Date</label>
                    <input type="date" class="form-control" id="inputProEnd" name="pdt" ng-model="entryForm.ProbationEndDate">
                </div>
                </div>
                <div class="form-group">
                <div class="form-inline">
                    <div class="form-group">
                        <label for="inputReStart">Reminder Start Date</label>
                        <input type="date" class="form-control" id="inputReStart" name="rsdt" ng-model="entryForm.ReminderStartDate">
                    </div>
                    <div class="form-group">
                        <label for="inputReEnd">Reminder End Date</label>
                        <input type="date" class="form-control" id="inputReEnd" name="redt" ng-model="entryForm.ReminderEndDate">
                    </div>
                </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default" name="submit">Create</button>
                </div>
			</fieldset>
		</form>
	</entry>
</div>
<!-- InstanceEndEditable -->
</div>
<div class="container" id="content"> <!-- InstanceBeginEditable name="content" -->
  <div id="vendorItem"> </div>
  <!-- InstanceEndEditable -->
  <div id="lasted_update"></div>
</div>
<div id="footer">
  <footer class="text-center">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <p>Copyright © MyCompany. All rights reserved.</p>
          </div>
        </div>
      </div>
  </footer>
</div>
</body>
<!-- InstanceEnd --></html>

<?php

if(isset($_POST['submit']))
{ 
$ev=$_POST['evcode'];
$de=$_POST['des'];
$st=$_POST['sdt'];
$et=$_POST['edt'];
$pt=$_POST['pdt'];
$rt=$_POST['rsdt'];
$dt=$_POST['redt'];

if($ev!="" && $de!="" && $st!="" && $et!="" && $pt!="" && $rt!="" && $dt!="")
{
$query="INSERT INTO CREATEEVALUATION VALUES ('$ev','$de','$st','$et','$pt','$rt','$dt')";

$data=mysqli_query($conn,$query);

if($data)
{
   //echo "data inserted into database";
}
}
else
{
   echo "failed to insert data into database";
}
}
?>