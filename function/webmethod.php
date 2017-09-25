<?php

/**
 * To get database.sql please contact me on aswad.ayub@gmail.com
 * Coded with love by Ayub Aswad aka. fsevenm
 */

require_once 'webdb.php';

// variable global

$divError = '<div class="error">';
$divSukses = '<div class="sukses">';
$divInfo = '<div class="info">';
$divBlues = '<div class="blues">';
$time = time();
$pesan = '';
$msgMark = 100;
$stambuk = ''; 
$namaTugas = ''; 
$waktuUpload = '';
$userUploadTime = '';

if (isset($_POST['keluar'])){
	session_destroy();
}


function getName($studentNumber){
	$query = "SELECT name FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

	return callQueryRows($query, 'name')[0];
}

function getAnalysis($studentNumber, $taskCode){
    $query = "SELECT analysis FROM amtu_user_analysis WHERE student_number = '$studentNumber' and task_code = '$taskCode'";

    return callQueryRows($query, 'analysis')[0];
}

function getRevision($studentNumber, $taskCode){
    $query = "SELECT revision FROM amtu_user_analysis WHERE student_number = '$studentNumber' and task_code = '$taskCode'";

    return callQueryRows($query, 'revision')[0];
}

function checkSeen1($studentNumber, $taskCode){
    $query = "SELECT revision FROM amtu_user_analysis WHERE student_number = '$studentNumber' and task_code = '$taskCode'";

    if (empty(trim(callQueryRows($query, 'revision')[0]))) {
        return 'Unseen';
    } else {
        return 'Seen and Scored';
    }
}

function getStartTime($studentNumber){
    $query = "SELECT start_time FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

    $startTime = callQueryRows($query, 'start_time')[0];
    $startTime = explode(' ', $startTime);
    return $startTime[3];
}

function getDueDate($taskCode){
    $query = "SELECT due_time FROM amtu_task_upload_limit WHERE task_name = '$taskCode'";

    $dueTime = callQueryRows($query, 'due_time')[0];
    $dueTime = explode(' ', $dueTime);
    return $dueTime[3] . ' - ' . $dueTime[2] . '/' . $dueTime[1] . '/' . $dueTime[0];
}

function getTaskCode($taskCode){
    $query = "SELECT task_name FROM amtu_task_upload_limit WHERE task_name = '$taskCode'";

    $taskCode = callQueryRows($query, 'task_name')[0];
    return $taskCode;
}

function getEndTime($studentNumber){
	$query = "SELECT end_time FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

	$endTime = callQueryRows($query, 'end_time')[0];
	$endTime = explode(' ', $endTime);
	return $endTime[3];
}


function checkTurnedIn($studentNumber, $taskCode){
    if (checkReadyAnalysis($studentNumber, $taskCode) === true){
        return '<span style="color: #6ef183">Turned in</span>';
    } else {
        return '<span style="color: indianred">Not turned in</span>';
    }
}

//function cekLogin(){
if (isset($_POST['log-user'])){
	$studentNumber = $_POST['stambuk'];
	$password = $_POST['kunci'];

	if (checkStudentNumber($studentNumber)) {
		if (callPassword($studentNumber)[0] === md5($password)) {
			$_SESSION['amtuUser'] = $studentNumber;
		} else {
			$msgMark = 1;
		}
	} else {
		$msgMark = 0;
	}
}
//}

//function cekSubmitAnalisa(){
if (isset($_POST['submit-analisa'])){
    $analysis = $_POST['analisa'];
    $studentNumber = $_SESSION['amtuUser'];

    if (!empty(trim($analysis))) {
        if (checkReadyAnalysis($studentNumber, 'PBDA1')) {
            $msgMark = 1;
        } else {
            addUserAnalysis('PBDA1', $studentNumber, $analysis);
            $msgMark = 2;
        }
    } else {
        $msgMark = 0;
    }
}

function addUserAnalysis($taskCode, $studentNumber, $analysis){
    $query = "INSERT INTO amtu_user_analysis (task_code, student_number, analysis) VALUES ('$taskCode','$studentNumber', '$analysis')";

    runQuery2($query);
}

function checkReadyAnalysis($studentNumber, $taskCode){
    $query = "SELECT student_number FROM amtu_user_analysis WHERE student_number = '$studentNumber' and task_code = '$taskCode'";

    return runQuery($query);
}


function checkStudentNumber($studentNumber){
	$query = "SELECT student_number FROM amtu_user WHERE student_number = '$studentNumber'";

	return runQuery($query);
}

function callPassword($studentNumber){
	$query = "SELECT u_key FROM amtu_user WHERE student_number = '$studentNumber'";

	return callQueryRows($query, 'u_key');
}

// register amtu user
if (isset($_POST['reg-user'])){
    $studentNumber = $_POST['stambuk'];
    $studentName = $_POST['nama'];
    $studentKey = $_POST['kunci'];
	if (empty(trim($studentNumber)) || empty(trim($studentName) || empty(trim($studentKey)))){
        $msgMark = 2;
    } else {
        if (checkUser($studentNumber)){
            $msgMark = 0;
        } else {
            addAmtuUser($studentNumber, $studentName, md5($studentKey));
            $msgMark = 1;
        }
    }
}

//function cekRegFinal() {
if (isset($_POST['register'])){
	$studentNumber = $_POST['stambuk'];
	$studentName = $_POST['nama'];
	$password = $_POST['sandi'];
	$password = md5($password);
	$notes = $_POST['catatan'];
	$rating = $_POST['rating'];

	if (!checkUserFinal($studentNumber)){
		if (proceedRegister($studentNumber,$studentName,$password,$notes,$rating,calculateFinalStartTime(),calculateFinalEndTime(7200))){
			if (checkUser($studentNumber)){
				// do nothing
			} else {
				addAmtuUser($studentNumber, $studentName);
			}
			$msgMark = 2;
		} else {
			$msgMark = 1;
		}
	} else {
		$msgMark = 0;
	}
}
//}

function addAmtuUser($studentNumber, $name, $key){
	$query = "INSERT INTO amtu_user (student_number, name, u_key) VALUES ('$studentNumber','$name', '$key')";

	runQuery2($query);
}

function callUserRegTime($studentNumber){
	$query = "SELECT reg_time FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

	return callQueryRows($query,'reg_time');
}

function calculateFinalStartTime(){
	global $time;
	$times  = date('Y m d H:i:s', $time);
	return $times;
}

function calculateFinalEndTime($finalDuration){
	global $time;
	$goodTime = $time + $finalDuration;
	$times  = date('Y m d H:i:s', $goodTime);
	return $times;
}

function checkUserFinal($studentNumber){
	$query = "SELECT student_number FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

	return runQuery($query);
}

function proceedRegister($studentNumber, $name, $password, $notes, $rating, $startTime, $endTime){
	$query = "INSERT INTO amtu_user_imk_final (student_number, name, password, notes_for_assistant, rating_trial, start_time, end_time) VALUES ('$studentNumber','$name','$password','$notes','$rating','$startTime','$endTime')";

	return runQuery2($query);
}

function checkTaskNameForFinal($taskName){
	if (($taskName === 'ProjectFinalPIMK') || ($taskName === 'ProjectFinalPSD')){
		return true;
	} else {
		return false;
	}
}

function callFinalTime($studentNumber){
	$query = "SELECT end_time FROM amtu_user_imk_final WHERE student_number = '$studentNumber'";

	return callQueryRows($query, 'end_time')[0];
}

function checkFinalTime($studentNumber){
	global $time;

	if (date('Y m d H:i:s', $time) < callFinalTime($studentNumber)) {
		return true;
	} else {
		return false;
	}
}

//function cekUpload() {
global $pesan, $divError, $divSukses, $divBlues, $studentNumber, $divInfo;
global $userUploadTime, $time;


$allowedTime = '2016 03 16 23 50 00';

if (isset($_POST['upl'])) {

    $fileName = $_FILES['file']['name'];
    $fileType = $_FILES['file']['type'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileError = $_FILES['file']['error'];
    $fileSize = $_FILES['file']['size'];

    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileNameDir = 'uploads/' . $fileName;
    $arrUser = $fileName; // array identitas pengguna

    $arrUser = explodeUserFileName($arrUser, $fileExtension);

    $stambuk = $arrUser[1];
    $namaTugas = $arrUser[0];

    insTrialUpload($arrUser[2], $fileName);

    if ($fileError == 0) {
        if (((strlen(trim($arrUser[0])) != 0) || (strlen(trim($arrUser[1])) != 0) || (strlen(trim($arrUser[2])) != 0) || (strlen(trim($arrUser[3])) != 0))) {
            if (checkTaskName($arrUser[0])) {
                if (strlen(trim($arrUser[1])) == 9) {
                    if (strlen(trim($arrUser[2])) >= 3) {
                        if (trim($arrUser[3]) === 'A') {
                            if (checkUser($arrUser[1])) {
                                if (checkTime($arrUser[0])) {
                                    if (checkAllowed($arrUser[0])) {
                                        if (checkUploadLimit($arrUser[0], $arrUser[1])) {
                                            if (checkMaxFileSize($fileSize, $arrUser[0])) {
                                                if (checkFileExtension($fileExtension, $arrUser[0])) {
                                                    if (checkTaskNameForFinal($arrUser[0])) {
                                                        if (checkStudentNumber($arrUser[1])) {
                                                            if (checkFinalTime($arrUser[1])) {
                                                                move_uploaded_file($fileTmpName, $fileNameDir);
                                                                $msgMark = 12;
                                                            } else {
                                                                $msgMark = 10;
                                                            }
                                                        } else {
                                                            $msgMark = 9;
                                                        }
                                                    } else {
                                                        move_uploaded_file($fileTmpName, $fileNameDir);
                                                        $msgMark = 11;
                                                    }
                                                    insUserTaskData($arrUser[1], $arrUser[0], $fileName);
                                                } else {
                                                    $msgMark = 8;
                                                }
                                            } else {
                                                $msgMark = 7;
                                            }

                                        } else {
                                            $msgMark = 6;
                                        }
                                    } else {
                                        $msgMark = 5;
                                    }
                                } else {
                                    $msgMark = 4;
                                }
                            } else {
                                $msgMark = 3;
                            }
                        } else {
                            $msgMark = 2;
                        }
                    } else {
                        $msgMark = 2;
                    }
                } else {
                    $msgMark = 2;
                }
            } else {
                $msgMark = 2;
            }
        } else {
            $msgMark = 1;
        }
    } else {
        $msgMark = 0;
    }
}
//}

if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {

    $fileName = $_FILES['upl']['name'];
    $fileType = $_FILES['upl']['type'];
    $fileTmpName = $_FILES['upl']['tmp_name'];
    $fileError = $_FILES['upl']['error'];
    $fileSize = $_FILES['upl']['size'];


    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileNameDir = 'uploads/' . $fileName;
    $arrUser = $fileName; // array identitas pengguna

    $arrUser = explodeUserFileName($arrUser, $fileExtension);

    $stambuk = $arrUser[1];
    $namaTugas = $arrUser[0];

    insTrialUpload($arrUser[2], $fileName);

    if ($fileError == 0) {
        if (((strlen(trim($arrUser[0])) != 0) || (strlen(trim($arrUser[1])) != 0) || (strlen(trim($arrUser[2])) != 0) || (strlen(trim($arrUser[3])) != 0))) {
            if (checkTaskName($arrUser[0])) {
                if (strlen(trim($arrUser[1])) == 9) {
                    if (strlen(trim($arrUser[2])) >= 3) {
                        if (trim($arrUser[3]) === 'A') {
                            if (checkUser($arrUser[1])) {
                                if (checkTime($arrUser[0])) {
                                    if (checkAllowed($arrUser[0])) {
                                        if (checkUploadLimit($arrUser[0], $arrUser[1])) {
                                            if (checkMaxFileSize($fileSize, $arrUser[0])) {
                                                if (checkFileExtension($fileExtension, $arrUser[0])) {
                                                    if (checkTaskNameForFinal($arrUser[0])) {
                                                        if (checkStudentNumber($arrUser[1])) {
                                                            if (checkFinalTime($arrUser[1])) {
                                                                move_uploaded_file($fileTmpName, $fileNameDir);
                                                                $msgMark = 12;
                                                                echo '{"status":"success"}';
                                                            } else {
                                                                $msgMark = 10;
                                                                echo '{"status":"error"}';
                                                            }
                                                        } else {
                                                            $msgMark = 9;
                                                            echo '{"status":"error"}';
                                                        }
                                                    } else {
                                                        move_uploaded_file($fileTmpName, $fileNameDir);
                                                        $msgMark = 11;
                                                        echo '{"status":"success"}';
                                                    }
                                                    insUserTaskData($arrUser[1], $arrUser[0], $fileName);
                                                } else {
                                                    $msgMark = 8;
                                                    echo '{"status":"error"}';
                                                }
                                            } else {
                                                $msgMark = 7;
                                                echo '{"status":"error"}';
                                            }

                                        } else {
                                            $msgMark = 6;
                                            echo '{"status":"error"}';
                                        }
                                    } else {
                                        $msgMark = 5;
                                        echo '{"status":"error"}';
                                    }
                                } else {
                                    $msgMark = 4;
                                    echo '{"status":"error"}';
                                }
                            } else {
                                $msgMark = 3;
                                echo '{"status":"error"}';
                            }
                        } else {
                            $msgMark = 2;
                            echo '{"status":"error"}';
                        }
                    } else {
                        $msgMark = 2;
                        echo '{"status":"error"}';
                    }
                } else {
                    $msgMark = 2;
                    echo '{"status":"error"}';
                }
            } else {
                $msgMark = 2;
                echo '{"status":"error"}';
            }
        } else {
            $msgMark = 1;
            echo '{"status":"error"}';
        }
    } else {
        $msgMark = 0;
        echo '{"status":"error"}';
    }
}


function checkUser($stambuk) {

	$query = "SELECT * FROM amtu_user where student_number = '$stambuk'";

	return runQuery($query);
}

function addTask($stambuk, $tugasKe, $downloadLink) {
	
	$query = "INSERT INTO amtu_user_task (student_number, task_name, download_link) VALUES ('$stambuk', '$tugasKe', '$downloadLink')";

	return runQuery($query); 
}

function callTime($namaTugas){

	$query = "SELECT due_time FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	return callQueryRows($query, 'due_time');
}

function checkTime($namaTugas){
	global $time;

	$arrDueTime = callTime($namaTugas);
	$strDueTime = implode('', $arrDueTime);

	if (date('Y m d H:i:s', $time) < $strDueTime) {
		return true;
	} else {
		return false;
	}
}

function callAllowed($namaTugas){

	$query = "SELECT allowed FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	return callQueryRows($query, 'allowed');
}

function checkAllowed($namaTugas){

	$arrAllowed = callAllowed($namaTugas);
	$arrAllowed = implode("", $arrAllowed);

	if ($arrAllowed == 1) {
		return true;
	} else {
		return false;
	}
}

function countTaskLimit($namaTugas){

	$query = "SELECT upload_limit FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	$arrLimitTugas = callQueryRows($query, 'upload_limit');
	return $arrLimitTugas;
}

function countUserUpload($namaTugas, $stambuk){

	$query = "SELECT count(*) AS uploaded_task FROM amtu_user_task WHERE student_number = '$stambuk' AND task_name = '$namaTugas'";

	$arrUploadedTask = callQueryRows($query, 'uploaded_task');
	return $arrUploadedTask;
}

function checkUploadLimit($namaTugas, $stambuk){

	$arrLimitTugas = countTaskLimit($namaTugas);
	$arrUploadedTask = countUserUpload($namaTugas, $stambuk);

	if ($arrUploadedTask[0] < $arrLimitTugas[0]) {
		return true;
	} else {
		return false;
	}
}

function callMaxFileSize($namaTugas){

	$query = "SELECT max_file_size FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	$arrMaxFileSize = callQueryRows($query, 'max_file_size');
	return $arrMaxFileSize;
}

function checkMaxFileSize($fileSize, $namaTugas){
	$arrMaxFileSize = callMaxFileSize($namaTugas);

	if ($fileSize < $arrMaxFileSize[0]) {
		return true;
	} else {
		return false;
	}
}

function callAllowedFileEx($namaTugas){

	$query = "SELECT * FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	$arrAllowedFormat = callQueryRows($query, 'allowed_file_eks');
	return $arrAllowedFormat;
}

// function checkFunction($namaTugas, $stambuk, $fileFormat){
// 	$arrLimitTugas = countTaskLimit($namaTugas);
// 	$arrUploadedTask = countUserUpload($namaTugas, $stambuk);
// 	$arrMaxFileSize = callMaxFileSize($namaTugas);
// 	$arrAllowedFormat = callAllowedFileEx($namaTugas);
// 	$arrDueTime = callTime($namaTugas);

// 	print_r($arrLimitTugas);
// 	print_r($arrUploadedTask);
// 	print_r($arrMaxFileSize);
// 	print_r($arrAllowedFormat);
// 	print_r($arrDueTime);
// }

function callQueryRows($query, $fieldName){
	global $db;
	$counter = 0;

	$data = $db->query($query);

	if ($data->num_rows > 0) {
		while ($row = $data->fetch_assoc()) {
			$fieldContent[0] = $row[$fieldName];
			$counter += 1;
		}
		return $fieldContent;
	}
}

function callUserUploadTime($namaTugas, $stambuk){
	global $db;

	$query = "SELECT time FROM amtu_user_task WHERE student_number = '$stambuk' AND task_name = '$namaTugas'";

	$data = $db->query($query);

	if ($data->num_rows > 0) {
		while ($row = $data->fetch_assoc()) {
			$time = $row['time'];
			return $time;
		}
	}
}


function checkFileExtension($fileFormat, $namaTugas){

	$arrAllowedFormat = callAllowedFileEx($namaTugas);
	$arrAllowedFormat = implode('', $arrAllowedFormat);
	$arrAllowedFormat = explode(',', $arrAllowedFormat);

	for ($i=0; $i < count($arrAllowedFormat); $i++) { 
		if ($fileFormat != $arrAllowedFormat[$i]) {
			// return false;
		} else {
			return true;
			break;
		}
	}
}

function explodeUserFileName($userFileName, $userFileExtension){
	$userFileName = str_replace('.'.$userFileExtension, "", $userFileName);
	$userFileName = explode("-", $userFileName);

	return $userFileName;
}

function checkTaskName($namaTugas){

	$query = "SELECT task_name FROM amtu_task_upload_limit WHERE task_name = '$namaTugas'";

	return runQuery($query);
}

function insUserTaskData($studentNumber, $taskName, $downloadLink) {
	$query = "INSERT INTO amtu_user_task (student_number,task_name,download_link) VALUES ('$studentNumber','$taskName','$downloadLink')";

	return runQuery2($query);
}

function insTrialUpload($name, $whats) {
	$query = "INSERT INTO amtu_upload_trial (name, whats) VALUES ('$name','$whats')";

	runQuery2($query);
}

function runQuery($query) {
	global $db;

	$data = $db->query($query);

	if ($data->num_rows > 0) {
		return true; 
	} else {
		return false;
	}

	$db->close();
}

function runQuery2($query){
	global $db;

	if ($db->query($query)) {
		return true;
	} else {
		return false;
	}
}

/**
 * To get database.sql please contact me on aswad.ayub@gmail.com
 * Coded with love by Ayub Aswad aka. fsevenm
 */

?>


