<?php
$title = "Academicyear | Online Examination Result Management System | SLGTI";
$description = "Online Examination Result  Management System (ERMS)-SLGTI";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./head.php"); ?>
    <?php include_once("../config.php"); ?>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script type="text/javascript" language="javascript">
        function show() {
            alert('<a href="http://www.codeproject.com/">Code Project</a>');
        }
    </script>
</head>

<body>
    <div class="page-wrapper toggled bg2 border-radius-on light-theme">
        <?php include_once("nav.php"); ?>
        <!-- card start -->
        <br>
        <div class="container">
            <?php
            $sumanana = null;
            $sss = null;
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "select b.batch_no,m.name as module,a.names ,c.name as course,c.code,a.type from assessments a inner join batches b on a.batch=b.id inner join modules m on m.id=a.module inner join courses c on m.course_code=c.code and a.id='$id';";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $batch = $row['batch_no'];
                    $module = $row['module'];
                    $name = $row['names'];
                    $course = $row['course'];
                    $type = $row['type'];
                    $c_code = $row['code'];
                }
            }
            ?>



            <?php
            if (isset($_POST['save'])) {
                //start
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = " select st.id from student s,student_enroll st where s.id=st.id and batch_no=$batch and course_code='$c_code'";
                    $sql_multi = null;
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $name = 'reg' . $row['id'];
                            $res = 'res' . $row['id'];
                            $att = 'att' . $row['id'];
                            $value = $_POST[$name];
                            $value2 = $_POST[$res];
                            $value3 = $_POST[$att];
                            $sql_multi .= "INSERT INTO  `student_assessments`(`assessment_id`,`student_id`,`marks`,`attempt`) 
                                                     VALUES ('$id','$value','$value2','$value3');";
                        }
                    }
                }

                //end

                if (mysqli_multi_query($con, $sql_multi)) {
                    echo "
               <div class='alert alert-success' role='alert'>
               insert success fully 
               <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                   <span aria-hidden='true'>&times;</span>
                </button>
              </div>";
                    $sss = "sumanan";
                } else {

                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                }
            }


            ?>
            <?php


            echo "<form action='assessment_result.php?id=$id' method='post'>";
            ?>
            <div class="card  mb-1">
                <div class="card-header bg-transparent ">
                    <div class="row">
                        <div class="col">
                            <h4>Assessment_Result</h4>
                        </div>
                        <div class="col-auto">

                            <a href="assessments.php" class="btn btn-outline-primary">Assessments</a> </div>
                    </div>
                </div>
                <div class="card-body ">

                    <div class="card mb-1">
                        <div class="card-body ">
                            <div class="container-fluid p-2">
                                <!-- #1 Insert Your Content-->
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <h6>Name</h6>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <h6 class="text-muted"><?php echo $name; ?>|<span class="badge badge-dark"><?php echo $type; ?></span></h6>
                                    </div>

                                    <div class="col-md-2 col-sm-12">
                                        <h6>Module</h6>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <h6 class="text-muted"><?php echo $module; ?></h6>
                                    </div>

                                    <div class="col-md-2 col-sm-12">
                                        <h6>Batch</h6>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <h6 class="text-muted"><?php echo $batch; ?> <span class="badge badge-dark"></span></h6>
                                    </div>

                                    <div class="col-md-2 col-sm-12">
                                        <h6>Course </h6>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <h6 class="text-muted"><?php echo $course; ?></h6>
                                    </div>



                                </div>



                            </div>
                        </div>
                    </div>
                    <br>
                    <form method='POST' action='assessment_result.php'>
                        <div class='row'>

                            <div class='form-group col-md-12 table-responsive'>
                                <table class='table align-middle'>
                                    <thead class='bg-primary text-light'>
                                        <tr>
                                        <?php
                                        if ($sss == "sumanan") {
                                            
                                        }
                                        else
                                        {
                                            ?>
                                            <th scope='col'>REG NO</th>
                                            <th scope='col'>STUDENT NAME</th>
                                            <th scope='col'>MARKS</th>
                                            <th scope='col'>ATTEMPT</th>
                                            <th scope='col'></th>
                                            <?php
                                        }
                                        ?>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($sss == "sumanan") {
                                               if(isset($_GET['id']))
                                               {
                                                $id=$_GET['id'];
                                                echo "<a href='assessment_resultview.php?id=$id'class='btn btn-sm' style='background-color: #0097c4 ; color: #ffffff;' > See result </a>";
                                               }
                                            } else {
                                            $sql = "select st.id,s.name_with_initials from student s,student_enroll st where s.id=st.id and batch_no=$batch and course_code='$c_code'";
                                            $result = mysqli_query($con, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<tr>
                                                    <td><input readonly name="reg', $row['id'], '" value="', $row['id'], '" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required ></td>
                                                    <td>', $row['name_with_initials'], '</td>
                                                    <td><input type="number" name="res', $row['id'], '" value="" min="0" max="100" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required ></td>
                                                    <td>
                                                    <div class="form-group">
                                                        <select class="form-control" id="exampleFormControlSelect1" style="width: 50%;" name="att', $row['id'], '" >
                                                            <option value="1">1 st</option>
                                                            <option  value="2">2 nd</option>
                                                            <option  value="3">3 rd</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                <div class="row">
                                                <div class="col"></div>
                                                <div class="col-auto">
                                                <a href="studentview.php?view=' . $row['id'] . '" class="btn btn-sm" style="background-color: #0097c4 ; color: #ffffff;" > student info </a>
                                            </div>
                                            <div>
                                            </td>
                                                </tr>';
                                            }
                                        }

                                        ?>
                                    </tbody>

                                </table>
                                <?php
                                if ($sss == "sumanan") {
                                      
                            } else {
                                ?>
                                    <button type='button' class='btn btn-warning btn btn-sm '>Close</button>
                                    <input type='submit' name='save' class='btn btn-primary btn btn-sm ' value="Save">
                                <?php
                            }
                        ?>

                            </div>
                        </div>
                    </form>
                </div>
                <!-- card end  -->
            </div>
            <?php include_once("../script.php"); ?>
</body>

</html>
