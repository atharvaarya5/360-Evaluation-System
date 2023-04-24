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
<title>360 Evaluation | Create Staff Profile</title>
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


app.controller('createPositionController', ['$scope', 'Security', 'MessageService', function ($scope, Security, MessageService, $rootScope) {
	$scope.directiveScopeDict = {};
	$scope.directiveCtrlDict = {};
    
	function Initialize(){
		var entryForm = {};
		var gender = [
		  {id: '1', name: 'Male', value: 'M'},
		  {id: '2', name: 'Female', value: 'F'}
		]
		
		var employStatus = [
		  {id: '1', name: 'Active', value: 'A'},
		  {id: '2', name: 'Terminated', value: 'T'}
		]
		
		$scope.entryForm = entryForm;
		$scope.gender = gender;
		$scope.employStatus = employStatus;
	}
	Initialize();
	
	$scope.EventListener = function(scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried EventListener()");
        var tagName = iElement[0].tagName.toLowerCase();
		var prgmID = scope.programId;
        var scopeID = scope.$id;
        var hashID = scopeID + '_' + tagName + '_' + prgmID;
        
		if($scope.directiveScopeDict[hashID] == null || typeof($scope.directiveScopeDict[hashID]) == "undefined"){
		  $scope.directiveScopeDict[hashID] = scope;
		  $scope.directiveCtrlDict[hashID] = controller;
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
		
		var record = controller.ngModel;
		record.EmployStatus = "A";
		record.Gender = "M";
	}
	
	$scope.StatusChange = function(fieldName, newValue, newObj, scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried StatusChange()");
		
		if(fieldName == "StaffID")
			newObj.StaffID = newObj.StaffID.toUpperCase(); 
	}
	
	$scope.ValidateBuffer = function(scope, iElement, iAttrs, controller){
		console.log("<"+iElement[0].tagName+">" +" Directive overried ValidateBuffer()");
		var isValid = true;
		var record = controller.ngModel;
		var msg = [];
		
        var staffID = record.StaffID;
		var employmentDate = record.EmploymentDate;
		var probationEndDate = record.ProbationEndDate;
		var birthday = record.BirthDay;
		
		// validate staffID
		if(!staffID || staffID == ""){
			isValid = false;
			msg.push("Staff ID is mandatory value");
			MessageService.setMsg(msg);
		}
		
		// validate Probation End Eate should on or before the Employment Date
		if(probationEndDate.getTime() < employmentDate.getTime()){
			isValid = false;
			msg.push("Probation End Date should on or before the Employment Date");
		}
		// validate birthday should before the employment date
		if(birthday.getTime() >= employmentDate.getTime()){
			isValid = false;
			msg.push("Birthday should before the Employment Date");
		}
		
		if(!isValid){
			MessageService.setMsg(msg);
            $("html, body").animate({ scrollTop: 0 }, "slow");
		}
		
        return isValid;
	}
    
    
    $scope.CustomSelectedToRecord = function(sRecord, rowScope, scope, iElement, controller){
        console.log("<"+iElement[0].tagName+">" +" Directive overried CustomPointedToRecord()");

        var tagName = iElement[0].tagName.toLowerCase();
        var prgmID = scope.programId.toLowerCase();
        var scopeID = scope.$id;
        var hashID = scopeID + '_' + tagName + '_' + prgmID;
        
        if(typeof $scope.directiveScopeDict[hashID].SetEditboxNgModel == "function")
            CustomSelectedToRecordUnderEditbox(sRecord, rowScope, scope, iElement, controller);
    }
    
    function CustomSelectedToRecordUnderEditbox(sRecord, rowScope, scope, iElement, controller){
        var tagName = iElement[0].tagName.toLowerCase();
        var prgmID = scope.programId.toLowerCase();
        var scopeID = scope.$id;
        var hashID = scopeID + '_' + tagName + '_' + prgmID;
        
        if(prgmID == "ew01dp"){
//          $scope.directiveScopeDict[hashID].SetEditboxNgModel(sRecord)
          $scope.entryForm.DepartmentCode = sRecord.DepartmentCode;
//          $scope.deptEditBox = sRecord;
        }

        if(prgmID == "ew01sg"){
//          $scope.directiveScopeDict[hashID].SetEditboxNgModel(sRecord)
          $scope.entryForm.StaffGradeCode = sRecord.StaffGradeCode;
//          $scope.staffGradeEditBox = sRecord;
        }

        if(prgmID == "ew01ps"){
//          $scope.directiveScopeDict[hashID].SetEditboxNgModel(sRecord)
          $scope.entryForm.PositionCode = sRecord.PositionCode;
//          $scope.positionEditBox = sRecord;
        }

        if(prgmID == "ew01sf"){
//          $scope.directiveScopeDict[hashID].SetEditboxNgModel(sRecord)
          $scope.entryForm.SupervisorID = sRecord.StaffID;
//          $scope.supervisorEditBox = sRecord;
        }
    }

    $scope.CustomSubmitDataResult = function(responseObj, httpStatusCode, scope, element, attrs, ctrl){
        var prgmID = scope.programId;
        if(prgmID == "es01sg"){
          $scope.directiveScopeDict["ew01sg"].ClearNRefreshData();
        }
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
<h1 class="page-header">Create Staff Profile</h1>
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
<div ng-controller="createPositionController as createDeptCtrl" style="max-width: 850px;">
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
	<h3>Create Staff Profile</h3>
    <entry ng-model="entryForm" program-id="ee01sf" edit-mode="create">
      <form ng-submit="SubmitData()" action="" method="POST">
        <fieldset>
          <div class="form-group">
            <label for="inputDeptCode">Staff ID</label>
            <input type="text" class="form-control" name="staffid" id="inputDeptCode" ng-model="entryForm.StaffID">
          </div>
          <div class="form-group">
            <label for="inputFN">First Name</label>
            <input type="text" class="form-control" name="firstname" id="inputFN" ng-model="entryForm.FirstName">
          </div>
          <div class="form-group">
            <label for="inputLN">LastName</label>
            <input type="text" class="form-control" name="lastname" id="inputLN" ng-model="entryForm.LastName">
          </div>
          <div class="form-group">
            <editbox ng-model="deptEditBox" program-id="ew01dp">
              <div class="form-inline">
                <label for="inputDept">Department Code</label>
                <div class="input-group">
                  <input class="form-control" type="text" name="deptcode" id="inputDept" ng-model="entryForm.DepartmentCode" readonly>
                  <span class="input-group-btn"><button type="button" class="btn btn-default" ng-click="OpenPageView()"><i class="fa fa-bars"></i></button></span>
                </div>
                <div class="form-group">
                  <label for="dept_desc"> Description</label>
                  <input type="text" class="form-control input-sm" name="deptdescription" id="dept_desc" ng-model="deptEditBox.Description" readonly>
                </div>
              </div>
            </editbox>
          </div>
          <div class="form-group">
            <editbox ng-model="staffGradeEditBox" program-id="ew01sg">
              <div class="form-inline">
                <label for="inputStaffGrade">Staff Grade Code</label>
                <div class="input-group">
                  <input class="form-control" type="text" name="staffgradecode" id="inputStaffGrade" ng-model="entryForm.StaffGradeCode" readonly>
                  <span class="input-group-btn"><button type="button" class="btn btn-default" ng-click="OpenPageView()"><i class="fa fa-bars"></i></button></span>
                </div>
                <div class="form-group">
                  <label for="sfg_desc">Description</label>
                  <input type="text" class="form-control input-sm" name="staffdescription" id="sfg_desc" ng-model="staffGradeEditBox.Description" readonly>
                </div>
              </div>
            </editbox>
          </div>
          <div class="form-group">
            <editbox ng-model="positionEditBox" program-id="ew01ps">
              <div class="form-inline">
                <label for="inputPos">Position Code</label>
                <div class="input-group">
                  <input class="form-control" type="text" id="inputPos" name="poscode" ng-model="entryForm.PositionCode" readonly>
                  <span class="input-group-btn"><button type="button" class="btn btn-default" ng-click="OpenPageView()"><i class="fa fa-bars"></i></button></span>
                </div>
                <div class="form-group">
                  <label for="pos_desc">Description</label>
                  <input type="text" class="form-control input-sm" id="pos_desc" name="posdescription" ng-model="positionEditBox.Description" readonly>
                </div>
              </div>
            </editbox>
          </div>
          <div class="form-group">
            <editbox ng-model="supervisorEditBox" program-id="ew01sf">
              <div class="form-inline">
                <label for="inputSupID">Supervisor ID</label>
                <div class="input-group">
                  <input class="form-control" type="text" id="inputSupID" name="supid" ng-model="entryForm.SupervisorID" readonly>
                  <span class="input-group-btn"><button type="button" class="btn btn-default" ng-click="OpenPageView()"><i class="fa fa-bars"></i></button></span>
                </div>
                <div class="form-group">
                  <label for="sf_fn">First Name</label>
                  <input type="text" class="form-control input-sm" name="supfirstname" id="sf_fn" ng-model="supervisorEditBox.FirstName" readonly>
                </div>
                <div class="form-group">
                  <label for="sf_ln">Last Name</label>
                  <input type="text" class="form-control input-sm" name="suplastname" id="sf_ln" ng-model="supervisorEditBox.LastName" readonly>
                </div>
              </div>
            </editbox>
          </div>
          <div class="form-group">
              <div class="form-inline">
                  <div class="form-group">
                    <label for="inputEmployDate">Employment Date</label>
                    <input type="date" class="form-control" name="empdt" id="inputEmployDate" ng-model="entryForm.EmploymentDate">
                  </div>
                  <div class="form-group">
                    <label for="inputProbatDate">Probation End Date</label>
                    <input type="date" class="form-control" name="prodt" id="inputProbatDate" ng-model="entryForm.ProbationEndDate">
                  </div>
          	  </div>
          </div>
          <div class="form-group">
              <div class="form-inline">
                  <div class="form-group">
                    <label for="inputEmployStatus">Employ Status</label>
                    <select class="form-control" name="inputEmployStatus" id="inputEmployStatus" ng-model="entryForm.EmployStatus">
                        <option ng-repeat="option in employStatus" value="{{option.value}}">{{option.name}}</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="inputGender">Gender</label>
                    <select class="form-control" name="inputGender" id="inputGender" ng-model="entryForm.Gender">
                        <option ng-repeat="option in gender" value="{{option.value}}">{{option.name}}</option>
                    </select>
                  </div>
			  </div>
          </div>
          <div class="form-group">
              <div class="form-inline">
                  <div class="form-group">
                    <label for="inputBirthDay">Birthday</label>
                    <input type="date" class="form-control" name="birthday" id="inputBirthDay" ng-model="entryForm.BirthDay">
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" name="email" id="inputEmail" ng-model="entryForm.Email">
                  </div>
          	  </div>
          </div>
          <div class="form-group">
              <div class="form-inline">
                  <div class="form-group">
                    <label for="inputTelNum">Telephone Number</label>
                    <input type="tel" class="form-control" name="telephone" id="inputTelNum" ng-model="entryForm.TelNum">
                  </div>
                  <div class="form-group">
                    <label for="inputMobileNum">Mobile Number</label>
                    <input type="tel" class="form-control" name="mobile" id="inputMobileNum" ng-model="entryForm.MobileNum">
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

$sid=$_POST['staffid'];
$fn=$_POST['firstname'];
$ln=$_POST['lastname'];
$dcode=$_POST['deptcode'];
$ddes=$_POST['deptdescription'];
$sg=$_POST['staffgradecode'];
$sdes=$_POST['staffdescription'];
$pcode=$_POST['poscode'];
$pdes=$_POST['posdescription'];
$supid=$_POST['supid'];
$sfn=$_POST['supfirstname'];
$sln=$_POST['suplastname'];
$emdt=$_POST['empdt'];
$prdt=$_POST['prodt'];
$estat=$_POST['inputEmployStatus'];
$gen=$_POST['inputGender'];
$bir=$_POST['birthday'];
$em=$_POST['email'];
$tel=$_POST['telephone'];
$mob=$_POST['mobile'];

if($sid!="" && $fn!="" && $ln!="" && $dcode!="" && $ddes!="" && $sg!="" && $sdes!="" && $pcode!="" && $pdes!="" && $supid!="" && $sfn!="" && $sln!="" && $emdt!="" && $prdt!="" && $estat!="" && $gen!="" && $bir!="" && $em!="" && $tel!="" &&$mob!="")
{
$query="INSERT INTO STAFFPROFILE VALUES ('$sid','$fn','$ln','$dcode','$ddes','$sg','$sdes','$pcode','$pdes','$supid','$sfn','$sln','$emdt','$prdt','$estat','$gen','$bir','$em','$tel','$mob')";

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
