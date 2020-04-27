<?php include('templates/connection.php'); ?>
<?php include("templates/header.php"); ?>

<html>
 <?php include("templates/header.php"); ?>
  <body>
    <div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Registration Page</div>
                      
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form action="insert.php" method="post">
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="text" class="form-control" name="fname" placeholder="First Name" required>
                            </div>  
                            
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <input id="login-password" type="text" class="form-control" name="lname" placeholder="Last Name" required>
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username"  autofocus required>                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password" required>
                            </div>
         
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <select id="login-user_level" name="usertype" class="form-control" required>
                                            <option value="reader" name="usertype" selected>Reader</option>
                                            <option value="admin" disabled>Admin</option>
                                        </select>
                            </div> 

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
                                
         <input type="button" class="btn btn-success pull-right" style='margin-left:25px' value="Cancel" 
          title="Click to return to main page." onclick="location.href = 'index.php';">                           
           <button type="submit" class="btn btn-success pull-right" title="Click here to save the records in the database." >
           <span class="glyphicon glyphicon-check"></span> Ok</button>
             
                                             
            </div>
        </div>
       </form>
                         </div>
     </div>
    </div> 
   </div> <!-- /container -->


 </html>

<?php include "templates/footer.php"; ?>