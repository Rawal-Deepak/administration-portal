<?php
// error_reporting(0);
include('private/document_server.php');
$document = new document;

session_start();
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
if (!$_SESSION['enrollment']) {
    header('location:signin');
}
if (isset($_SESSION['enrollment'])) {
    $enroll = $_SESSION['enrollment'];
    $studentInfo = $document->getStudentInfo($enroll);
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
    $purpose = addslashes($_POST['reason']);
    if ($purpose == "Other") {
        $purpose = '';
        $purpose = addslashes($_POST['other_reason']);
    }
    $date = addslashes($_POST['date']);
    $document10th = '0';
    $document12th = '0';
    $leaving_certificate = '0';
    if (isset($_POST['10th'])) {
        $document10th = addslashes($_POST['10th']);
    }
    if (isset($_POST['12th'])) {
        $document12th = addslashes($_POST['12th']);
    }
    if (isset($_POST['leaving_certificate'])) {
        $leaving_certificate = addslashes($_POST['leaving_certificate']);
    }
    $feesrecipt = $_FILES['fees_recipt']['name'];
    $tempname = $_FILES['fees_recipt']['tmp_name'];
    $savefilename = $enroll . "_" . $sem . "_" . $feesrecipt;
    $folder = "../Admin_side/private/Fees_recipt/" . $savefilename;
    move_uploaded_file($tempname, $folder);
    // Insert Data
    $document->insert($enroll, $name, $fathername, $course, $sem, $mobile, $email, $purpose, $date, $document10th, $document12th, $leaving_certificate, $savefilename);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request For Document</title>
    <link rel="icon" href="private/assets/images/BMCCA_logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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
        <div class="bg-[#F3F7F6] w-[64rem] px-14 py-8 rounded-xl shadow-md flex flex-col justify-start"
            style="background: linear-gradient(90deg, #e3ffe7 0%, #d9e7ff 100%);">
            <h1 class="text-3xl font-medium">Request For Documents :</h1>
            <form action="" method="post" id="document_form" enctype="multipart/form-data">
                <div class="grid grid-cols-2 mt-6 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1">
                        <label for="Fullname" class="text-xl">Full Name</label>
                        <!-- pattern="^[A-Za-z]+\s[A-Za-z]+\s[A-Za-z]+$" -->
                        <input required readonly type="text" name="fullname" placeholder="Enter Your Fullname" value="<?php if (isset($name)) {
                            echo $name;
                        } ?>"
                            class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed"
                            id="fullname">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Fathername" class="text-xl">Father Name</label>
                        <input required readonly type="text" name="fathername" placeholder="Enter Your Father Name"
                            value="<?php if (isset($fathername)) {
                                echo $fathername;
                            } ?>"
                            class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed">
                    </div>
                </div>
                <div class="grid grid-cols-4 mt-5 gap-x-10">
                    <div class="col-span-2 flex flex-col gap-y-1 ">
                        <label for="Enrollment" class="text-xl">Enrollment Number</label>
                        <input required readonly type="text" name="enrollment" value="<?php if (isset($enroll)) {
                            echo $enroll;
                        } ?>" placeholder="Enter Your Enrollment Number"
                            class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Course" class="text-xl">Course</label>
                        <input readonly required
                            class="bg-white h-12 rounded-lg pl-2 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed"
                            type="text" name="course" id="Course" value="<?php if (isset($crs)) {
                                echo $crs;
                            } ?>">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Semester" class="text-xl">Semester</label>
                        <select name="semester" id="Semester" class="bg-white h-12 rounded-lg pl-2 text-lg outline-none focus:ring-2 focus:ring-indigo-800" required>
                            <option value="" class="hidden">Choose Semester</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-5 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1 ">
                        <label for="Email" class="text-xl">Email</label>
                        <input required readonly type="email" name="email" placeholder="Enter Your Email"
                            class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed"
                            value="<?php if (isset($email)) {
                                echo $email;
                            } ?>">
                    </div>
                    <div class="row-span-2 flex flex-col gap-y-1 ">
                        <label for="Mobile No" class="text-xl">Mobile No</label>
                        <input required readonly type="tel" name="mobile" pattern="[0-9]{10}"
                            placeholder="Enter Your Mobile No"
                            class="bg-white h-12 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 cursor-not-allowed"
                            value="<?php if (isset($mobile)) {
                                echo $mobile;
                            } ?>">
                    </div>
                </div>
                <div class="grid grid-cols-4 mt-5 gap-x-10">
                    <div class="row-span-1 flex flex-col gap-y-1">
                        <label for="Reason For Bonafide Issue" class="text-xl">Select Document</label>
                        <div class="row-span-1 flex items-center mt-1 relative">
                            <input type="checkbox" id="10th" name="10th" value="1" class="h-4 w-4">
                            <label for="10th" class="ml-2 text-lg">10<sup>th</sup> Result</label>
                        </div>
                        <div class="row-span-1 flex items-center mt-1">
                            <input type="checkbox" id="12th" name="12th" value="1"
                                class="h-4 w-4 text-indigo-600 bg-indigo-600">
                            <label for="12th" class="ml-2 text-lg">12<sup>th</sup> Result</label>
                        </div>
                        <div class="row-span-1 flex items-center mt-1">
                            <input type="checkbox" id="leaving_certificate" name="leaving_certificate" value="1"
                                class="h-4 w-4 text-indigo-600 bg-indigo-600">
                            <label for="leaving_certificate" class="ml-2 text-lg">Leaving Certificate</label>
                        </div>
                    </div>
                    <div class="flex flex-col row-span-1">
                        <label for="date" class="text-xl">Return Date</label>
                        <input required type="date" name="date" id="date"
                            class="mt-2 h-12 pl-2 w-full rounded-lg focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 outline-none">
                    </div>
                    <div class="col-span-2 flex flex-col gap-y-1">
                        <label for="Reason For Bonafide Issue" class="text-xl">Reason For Documents</label>
                        <div role="radiogroup" class="grid grid-cols-2">
                            <div class="flex items-center col-span-1 py-1">
                                <input required type="radio" name="reason" id="BRTS Pass" value="BRTS Pass"
                                    class="h-4 w-4 cursor-pointer border-indigo-800 text-indigo-800 focus:ring-2 focus:ring-offset-2 rounded-full focus:outline-none focus:ring-indigo-800">
                                <label for="BRTS Pass" class="text-lg cursor-pointer ml-2">BRTS Pass</label>
                            </div>
                            <div class="flex items-center col-span-1">
                                <input required type="radio" name="reason" id="Digital India" value="Digital India"
                                    class="h-4 w-4 cursor-pointer border-indigo-800 text-indigo-800 focus:ring-2 focus:ring-offset-2 rounded-full focus:outline-none focus:ring-indigo-800">
                                <label for="Digital India" class="text-lg cursor-pointer ml-2">Digital India</label>
                            </div>
                            <div class="flex items-center col-span-1 py-1">
                                <input required type="radio" name="reason" id="Education Loan" value="Education Loan"
                                    class="h-4 w-4 cursor-pointer border-indigo-800 text-indigo-800 focus:ring-2 focus:ring-offset-2 rounded-full focus:outline-none focus:ring-indigo-800">
                                <label for="Education Loan" class="text-lg cursor-pointer ml-2">Education Loan</label>
                            </div>
                            <div class="flex items-center">
                                <input required type="radio" name="reason" id="Driving License" value="Driving License"
                                    class="h-4 w-4 cursor-pointer border-indigo-800 text-indigo-800 focus:ring-2 focus:ring-offset-2 rounded-full focus:outline-none focus:ring-indigo-800">
                                <label for="Driving License" class="text-lg cursor-pointer ml-2">Driving License</label>
                            </div>
                            <div class="flex items-center col-span-1 py-1">
                                <input required type="radio" name="reason" id="Others" value="Other"
                                    class="h-4 w-4 cursor-pointer border-indigo-800 text-indigo-800 focus:ring-2 focus:ring-offset-2 rounded-full focus:outline-none focus:ring-indigo-800 peer">
                                <label for="Others" class="text-lg cursor-pointer ml-2">Others</label>
                            </div>
                        </div>
                        <div>
                            <input type="text" name="other_reason" id="other_reason"
                                placeholder="Enter Your Other Reason"
                                class="bg-white w-96 ml-5 mt-1 h-10 rounded-lg pl-3 text-lg outline-none focus:ring-2 focus:ring-indigo-800 hidden">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-3">
                    <div class="flex flex-col row-span-1">
                        <label for="Fees" class="text-xl">Upload current semester Fees Recipt</label>
                        <input required type="file" name="fees_recipt" id="Fees"
                            class="mt-3 file:outline-none file:h-12 file:w-36 file:rounded-lg cursor-pointer file:cursor-pointer file:border-0 file:bg-white focus:ring-2 focus:ring-indigo-800 focus:rounded-lg text-lg file: file:text-gray-400">
                    </div>
                </div>
                <div class="w-full mt-3 flex justify-end">
                    <input
                        class="bg-red-700 text-white h-12 px-7 text-lg rounded-lg focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 mr-8"
                        type="reset" value="Reset">
                    <button
                        class="bg-indigo-800 text-white h-12 px-5 text-lg rounded-lg focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-800"
                        name="insert">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        document.getElementById("document_form").addEventListener("submit", function (event) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length === 0) {
                event.preventDefault(); // Prevent form submission
                alert("Please select at least one document."); // Display an alert to the user
            }
        });

        // Radio Button onclick TextBox Show and Hide
        const other_radio = document.querySelector('input[value=Other]');
        const other_reason = document.getElementById('other_reason');
        other_radio.addEventListener('change', function () {
            if (other_radio.checked) {
                other_reason.classList.remove('hidden');
                other_reason.required = true;
                other_reason.focus();
            } else {
                other_reason.classList.add('hidden');
            }
        });
        const brts_radio = document.getElementById('BRTS Pass');
        brts_radio.addEventListener('change', function () {
            if (brts_radio.checked) {
                other_reason.classList.add('hidden');
                other_reason.required = false;

            }
        });
        const mysy_radio = document.getElementById('Digital India');
        mysy_radio.addEventListener('change', function () {
            if (mysy_radio.checked) {
                other_reason.classList.add('hidden');
                other_reason.required = false;
            }
        });
        const education_radio = document.getElementById('Education Loan');
        education_radio.addEventListener('change', function () {
            if (education_radio.checked) {
                other_reason.classList.add('hidden');
                other_reason.required = false;

            }
        });
        const driving_radio = document.getElementById('Driving License');
        driving_radio.addEventListener('change', function () {
            if (driving_radio.checked) {
                other_reason.classList.add('hidden');
                other_reason.required = false;
            }
        });

        // semester change
        const Semester = document.getElementById('Semester');
        Semester.addEventListener('focus', () => {
            const Course = document.getElementById('Course').value;
            jQuery.ajax({
                url: 'private/document_server.php',
                type: 'POST',
                data: "&course_code=" + Course,
                success: function(response) {
                    const code = response;
                    $('#Semester').html(code);
                }
            })
        });
    </script>
</body>

</html>