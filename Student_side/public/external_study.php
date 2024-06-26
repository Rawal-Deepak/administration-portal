<?php
// error_reporting(0);
include('private/external_study_server.php');
$external = new external;

session_start();
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
if (!$_SESSION['enrollment']) {
    header('location:signin');
}
if (isset($_SESSION['enrollment'])) {
    $enroll = $_SESSION['enrollment'];
    $studentInfo = $external->getStudentInfo($enroll);
    $sem = $studentInfo['sem'];
    $crs = $studentInfo['crs'];
    $name = $studentInfo['name'];
    $fathername = $studentInfo['fathername'];
    $email = $studentInfo['email'];
    $mobile = $studentInfo['mobile'];
} else {
    echo "No enrollment number found in session.";
}
if (isset($_POST['insert'])) {
    $name = addslashes($_POST['fullname']);
    $fathername = addslashes($_POST['fathername']);
    $enroll = addslashes($_POST['enrollment']);
    $course = addslashes($_POST['course']);
    $sem = addslashes($_POST['semester']);
    $email = addslashes($_POST['email']);
    $mobile = addslashes($_POST['mobile']);
    $document_tc = '0';
    $document_migration = '0';
    $document_pdc = '0';
    if (isset($_POST['tc'])) {
        $document_tc = addslashes($_POST['tc']);
    }
    if (isset($_POST['migration'])) {
        $document_migration = addslashes($_POST['migration']);
    }
    if (isset($_POST['pdc'])) {
        $document_pdc = addslashes($_POST['pdc']);
    }
    $feesrecipt = $_FILES['marksheet']['name'];
    $tempname = $_FILES['marksheet']['tmp_name'];
    $savefilename = $enroll . "_" . $sem . "_" . $feesrecipt;
    $folder = "../Admin_side/private/marksheet/" . $savefilename;
    move_uploaded_file($tempname, $folder);
    // Insert Data
    $external->insert($enroll, $name, $fathername, $course, $sem, $mobile, $email,  $document_tc, $document_migration, $document_pdc, $savefilename);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request For T.C Migration..</title>
    <link rel="icon" href="private/images/fav.png">
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Geologica', sans-serif;">
    <div class="shadow-lg shadow-gray-100">
        <nav class="bg-white py-2 flex justify-center">
            <ul>
                <li>
                    <a href="home">
                        <img src="private/images/logo.png" alt="bmu" class="w-32">
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="flex items-center justify-center mt-3">
        <div class="bg-[#F3F7F6] w-[64rem] px-14 py-8 rounded-xl shadow-md flex flex-col justify-start" style="background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);">
            <h1 class="text-2xl font-medium">Request For Transfer , Migration & Provisional Degree Certificate :</h1>
            <form action="" method="post" id="document_form" enctype="multipart/form-data">
                <div class="grid grid-cols-2 mt-6 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1">
                        <label for="Fullname" class="text-xl">Full Name</label>
                        <!-- pattern="^[A-Za-z]+\s[A-Za-z]+\s[A-Za-z]+$" -->
                        <input required readonly type="text" name="fullname" placeholder="Enter Your Fullname" value="<?php if (isset($name)) {
                                                                                                                            echo $name;
                                                                                                                        } ?>" class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed" id="fullname">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Fathername" class="text-xl">Father Name</label>
                        <input required readonly type="text" name="fathername" placeholder="Enter Your Father Name" value="<?php if (isset($fathername)) {
                                                                                                                                echo $fathername;
                                                                                                                            } ?>" class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed">
                    </div>
                </div>
                <div class="grid grid-cols-4 mt-5 gap-x-10">
                    <div class="col-span-2 flex flex-col gap-y-1 ">
                        <label for="Enrollment" class="text-xl">Enrollment Number</label>
                        <input required readonly type="text" name="enrollment" value="<?php if (isset($enroll)) {
                                                                                            echo $enroll;
                                                                                        } ?>" placeholder="Enter Your Enrollment Number" class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Course" class="text-xl">Course</label>
                        <input readonly required class="bg-white h-12 rounded-lg pl-2 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed" type="text" name="course" value="<?php if (isset($crs)) {
                                                                                                                                                                                                        echo $crs;
                                                                                                                                                                                                    } ?>" id="">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Semester" class="text-xl">Semester</label>
                        <input readonly required class="bg-white h-12 rounded-lg pl-2 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed" type="text" name="semester" value="<?php if (isset($sem)) {
                                                                                                                                                                                                            echo $sem;
                                                                                                                                                                                                        } ?>" id="">
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-5 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1 ">
                        <label for="Email" class="text-xl">Email</label>
                        <input required readonly type="email" name="email" placeholder="Enter Your Email" class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed" value="<?php if (isset($email)) {
                                                                                                                                                                                                                                        echo $email;
                                                                                                                                                                                                                                    } ?>">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Mobile No" class="text-xl">Mobile No</label>
                        <input required readonly type="tel" name="mobile" pattern="[0-9]{10}" placeholder="Enter Your Mobile No" class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed" value="<?php if (isset($mobile)) {
                                                                                                                                                                                                                                                                echo $mobile;
                                                                                                                                                                                                                                                            } ?>">
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-5 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1">
                        <label for="Reason For Bonafide Issue" class="text-xl">Select Document</label>
                        <div class="row-span-1 flex items-center mt-1 relative">
                            <input type="checkbox" id="tc" name="tc" value="1" class="h-4 w-4">
                            <label for="tc" class="ml-2 text-lg">Transfer Certificate</label>
                        </div>
                        <div class="row-span-1 flex items-center mt-1">
                            <input type="checkbox" id="migration" name="migration" value="1" class="h-4 w-4 text-indigo-600 bg-indigo-600">
                            <label for="migration" class="ml-2 text-lg">Migration Certificate</label>
                        </div>
                        <div class="row-span-1 flex items-center mt-1">
                            <input type="checkbox" id="pdc" name="pdc" value="1" class="h-4 w-4 text-indigo-600 bg-indigo-600">
                            <label for="pdc" class="ml-2 text-lg">Provisional Degree Certificate</label>
                        </div>
                    </div>
                    <div class="flex flex-col row-span-1">
                        <label for="Fees" class="text-xl">Upload Final semester Marksheet</label>
                        <input required type="file" name="marksheet" id="marksheet" class="mt-3 file:outline-none file:h-12 file:w-36 file:rounded-lg cursor-pointer file:cursor-pointer file:border-0 file:bg-white focus:ring-2 focus:ring-indigo-800 focus:rounded-lg text-lg file: file:text-gray-400">
                    </div>
                </div>
                <div class="w-full mt-3 flex justify-end">
                    <input class="bg-red-700 text-white h-12 px-7 text-lg rounded-lg focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 mr-8" type="reset" value="Reset">
                    <button class="bg-indigo-800 text-white h-12 px-5 text-lg rounded-lg focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-800" name="insert">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("document_form").addEventListener("submit", function(event) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                event.preventDefault(); // Prevent form submission
                alert("Please select at least one document."); // Display an alert to the user
            }
        });
    </script>
</body>

</html>