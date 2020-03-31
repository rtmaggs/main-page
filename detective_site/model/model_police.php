<?php

    include (__DIR__ . '/database.php');

    function addSuspect($firstname, $lastname, $address, $dob, $eye_color, $weight, $height, $arrest_time, $wanted_level, $photo, $case_id)
    {
        global $database;
        $results = "";
        $stmt = $database ->prepare("INSERT INTO suspects SET firstname = :firstname, lastname = :lastname, address = :address, dob = :dob, eye_color = :eye_color, height = :height, suspect_weight = :suspect_weight, arrest_time = :arrest_time, wanted_level = :wanted_level, photo = :photo, case_id = :case_id");
        $binds = array(
            ":firstname" => $firstname,
            ":lastname" => $lastname,
            ":address" => $address,
            ":dob" => $dob,
            ":eye_color" => $eye_color,
            ":height" => $height,
            ":suspect_weight" => $weight,
            ":arrest_time" => $arrest_time,
            ":wanted_level" => $wanted_level,
            ":photo" => $photo,
            ":case_id" => $case_id
        );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }

    function updateSuspect($firstname, $lastname, $address, $dob, $eye_color, $height, $weight, $arrest_time, $wanted_level, $photo, $suspect_id) 
    {
        global $database;
        if(!isset($photo)){
            $photo = "";
        }
        $stmt = $database ->prepare("UPDATE suspects SET firstname = :firstname, lastname = :lastname, address = :address, dob = :dob, eye_color = :eye_color, height = :height, suspect_weight = :suspect_weight, arrest_time = :arrest_time, wanted_level = :wanted_level, photo = :photo WHERE suspect_id = :suspect_id");
        $results = "";
        $binds = array(
            ":firstname" => $firstname,
            ":lastname" => $lastname,
            ":address" => $address,
            ":dob" => $dob,
            ":eye_color" => $eye_color,
            ":height" => $height,
            ":suspect_weight" => $weight,
            ":arrest_time" => $arrest_time,
            ":wanted_level" => $wanted_level,
            ":photo" => $photo,
            ":suspect_id" => $suspect_id
            
        );

        $results = "Failed to update suspect.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The suspect was updated.';
        }

        return ($results);
    }

    function viewSuspect($suspect_id) 
    {
        global $database;

        $result = [];
        $insert = $database->prepare("SELECT suspect_id, firstname, lastname, address, dob, eye_color, weight, height, arrest_time, wanted_level, photo, case_id FROM suspects WHERE suspect_id =: suspect_id");
        $combine = array(
            ":suspect_id" => $suspect_id
        );

        if ( $insert->execute($combine) && $insert->rowCount() > 0 ) 
        {
            $result = $insert->fetch(PDO::FETCH_ASSOC);
        }

        return ($result);
    }
    
    function grabSuspects($id) 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT firstname, lastname, address, dob, eye_color, height, suspect_weight, wanted_level, arrest_time, photo FROM suspects WHERE suspect_id = :suspect_id";
        
        
        $stmt = $database->prepare($sql);
         $binds = array(
            "suspect_id" => $id
        );
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }   
    
    function getSuspects () 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT * FROM suspects";
        
        
        $stmt = $database->prepare($sql);
 
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetchALL(PDO::FETCH_ASSOC);               
         }
         
         return ($results);
    }
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/

    function addCase($case_title, $case_description, $is_active)
    {
          global $database;
          $results = "";
          $stmt = $database ->prepare("INSERT INTO cases SET case_title = :case_title, case_description = :case_description, is_active = :is_active");
          $binds = array(
              ":case_title" => $case_title,
              ":case_description" => $case_description,
              ":is_active" => $is_active
              );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }

    function updateCase($case_title, $case_description, $is_active, $case_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE cases SET case_title = :case_title, case_description = :case_description, is_active = :is_active WHERE case_id = :case_id");
        $results = "";
        $binds = array(
            ":case_title" => $case_title,
            ":case_description" => $case_description,
            ":is_active" => $is_active,
            ":case_id" => $case_id
        );

        $results = "Failed to update the case.";
        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The case was updated';
        }

        return ($results);
    }

    function viewCase($id) 
    {
        global $database;

        $result = [];
        $insert = $database->prepare("SELECT case_id, case_title, case_description, is_active FROM cases WHERE case_id =: case_id");
        $combine = array(
            ":case_id" => $id
        );

        if($insert->execute($combine) && $insert->rowCount() > 0 ) 
        {
            $result = $insert->fetch(PDO::FETCH_ASSOC);
        }

        return ($result);
    }
    
    function deleteCase($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM cases where case_id = :case_id");
    
        $binds = array(
            ":case_id" => $id
        );
    
        $results = "Failed to delete case.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Case was successfully deleted.";
        }
    }

    function deleteAnnouncement($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM announcements where announcement_id = :announcement_id");
    
        $binds = array(
            ":announcement_id" => $id
        );
    
        $results = "Failed to delete announcement.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Announcement was successfully deleted.";
        }
    }

    function deleteEmployee($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM employees where employee_id = :employee_id");
    
        $binds = array(
            ":employee_id" => $id
        );
    
        $results = "Failed to delete employee.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Employee was successfully deleted";
        }

    }

    function deleteSuspect($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM suspect where suspect_id = :suspect_id");
    
        $binds = array(
            ":suspect_id" => $id
        );
    
        $results = "Failed to delete suspect.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Suspect was successfully deleted";
        }

    }

    function deleteWitness($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM witnesses where witness_id = :witness_id");
    
        $binds = array(
            ":witness_id" => $id
        );
    
        $results = "Failed to delete witness.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Witness was successfully deleted";
        }

    }

    function deleteEvidence($id) 
    {
        global $database;

        $stmt = $database->prepare("DELETE FROM evidence where evidence_id = :evidence_id");
    
        $binds = array(
            ":evidence_id" => $id
        );
    
        $results = "Failed to delete evidence.";
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = "Evidence was successfully deleted";
        }

    }
    
    function grabCases($id) 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT case_id, case_title, case_description, is_active FROM cases WHERE case_id = :case_id";
        
        
        $stmt = $database->prepare($sql);
         $binds = array(
            "case_id" => $id
        );
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/


    function addWitness($firstname, $lastname, $phone, $witness_statement, $photo, $case_id)
    {
          global $database;
          $results = "";
          $stmt = $database ->prepare("INSERT INTO witnesses SET firstname = :firstname, lastname = :lastname, phone = :phone, witness_statement = :witness_statement, photo = :photo, case_id = :case_id");
          $binds = array(
              ":firstname" => $firstname,
              ":lastname" => $lastname,
              ":phone" => $phone,
              ":witness_statement" => $witness_statement,
              ":photo" => $photo,
              ":case_id" => $case_id
            );

        $results = "Failed to add witness.";
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = "Witness added.";               
        }

        return ($results);
    }

    function updateWitness($firstname, $lastname, $phone, $witness_statement, $photo, $witness_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE witnesses SET firstname = :firstname, lastname = :lastname, phone = :phone, witness_statement = :witness_statement, photo = :photo where witness_id = :witness_id");
        $results = "";
        $binds = array(
            ":firstname" => $firstname,
            ":lastname" => $lastname,
            ":phone" => $phone,
            ":witness_statement" => $witness_statement,
            ":photo" => $photo,
            ":witness_id" => $witness_id
            
        );

        $results = "Failed to update witness.";
        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The witness was updated';
        }

        return ($results);
    }

    function viewWitness($witness_id) 
    {
        global $database;

        $result = [];
        $insert = $database->prepare("SELECT witness_id, firstname, lastname, phone, witness_statement, photo, case_id FROM witnesses WHERE witness_id =: witness_id");
        $combine = array(
            ":witness_id" => $witness_id
        );

        if($insert->execute($combine) && $insert->rowCount() > 0 ) 
        {
            $result = $insert->fetch(PDO::FETCH_ASSOC);
        }

        return ($result);
    }
    
    function getWitnesses($id) 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT firstname, lastname, phone, witness_statement, photo from witnesses where witness_id =:witness_id";
        
        
        $stmt = $database->prepare($sql);
         $binds = array(
            "witness_id" => $id
        );
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }
    
    function listWitnesses () 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT * FROM witnesses";
        
        
        $stmt = $database->prepare($sql);
 
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetchALL(PDO::FETCH_ASSOC);               
         }
         
         return ($results);
    }
    
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/

    function addAnnouncement($announcement_title, $announcement)
    {
          global $database;
          $results = "";
          $stmt = $database ->prepare("INSERT INTO announcements SET announcement_title = :announcement_title, announcement = :announcement, employee_id = :employee_id");
          $binds = array(
              ":announcement_title" => $announcement_title,
              ":announcement" => $announcement,
              ":employee_id" => $employee_id
              );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }


    function updateAnnouncement($announcement_title, $announcement, $announcement_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE announcements SET announcement_title = :announcement_title, announcement = :announcement where announcement_id = :announcement_id ");
        $results = "";
        $binds = array(
            ":announcement_id" => $announcement_id,
            ":announcement_title" => $announcement_title,
            ":announcement" => $announcement
         );

        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The announcement was updated';
        }

        return ($results);
    }
    
    function listAnnouncements () 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT announcements.announcement_id, announcements.announcement_title, announcements.announcement, announcements.post_time, employees.employee_id, employees.firstname, employees.lastname FROM announcements LEFT JOIN employees ON announcements.employee_id = employees.employee_id GROUP BY post_time DESC";
        
        
        $stmt = $database->prepare($sql);
 
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetchALL(PDO::FETCH_ASSOC);               
         }
         
         return ($results);
    }
    
    function grabAnnouncements($id) {
        global $database;
        
        $results = [];
        $stmt = $database ->prepare("SELECT announcement_title, announcement from announcements where announcement_id =:announcement_id");
        
        
        $binds = array(
            "announcement_id" => $id
        );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }   
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/


    function addEmployee($firstname, $lastname, $job_title, $email, $pwd, $phone, $photo, $case_id)
    {
          global $database;
          $results = "";

          if(!isset($photo)){
            $photo = "";
          }

          $stmt = $database ->prepare("INSERT INTO employees SET firstname = :firstname, lastname = :lastname, job_title = :job_title, email = :email, pwd = :pwd, phone = :phone, photo = :photo, case_id = :case_id");
          $binds = array(
              ":firstname" => $firstname,
              ":lastname" => $lastname,
              ":job_title" => $job_title,
              ":email" => $email,
              ":pwd" => sha1($pwd), 
              ":phone" => $phone,
              ":photo" => $photo,
              ":case_id" => $case_id
            );

        $results = "Failed to add employee.";
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }

    function updateEmployee($firstname, $lastname, $job_title, $email, $pwd, $phone, $photo, $employee_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE employees SET firstname = :firstname, lastname = :lastname, job_title = :job_title, email = :email, pwd = :pwd, phone = :phone, photo = :photo where employee_id = :employee_id");
        $results = "";
        $binds = array(
            ":firstname" => $firstname,
            ":lastname" => $lastname,
            ":job_title" => $job_title,
            ":email" => $email,
            ":pwd" => sha1($pwd),
            ":phone" => $phone,
            ":photo" => $photo,
            ":employee_id" => $employee_id
        );

        $results = $lastname;
        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The employee was updated';
        }

        return ($results);
    }

    function updateEmployeeWithoutPassword($firstname, $lastname, $job_title, $email, $phone, $photo, $employee_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE employees SET firstname = :firstname, lastname = :lastname, job_title = :job_title, email = :email, phone = :phone, photo = :photo where employee_id = :employee_id");
        $results = "";
        $binds = array(
            ":firstname" => $firstname,
            ":lastname" => $lastname,
            ":job_title" => $job_title,
            ":email" => $email,
            ":phone" => $phone,
            ":photo" => $photo,
            ":employee_id" => $employee_id
        );

        $results = $lastname;
        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The employee was updated';
        }

        return ($results);
    }
    
    function grabEmployees($id) {
        global $database;
        
        $stmt = $database ->prepare("SELECT firstname, lastname, job_title, email, pwd, phone, photo FROM employees WHERE employee_id = :employee_id");
		
        $binds = array(
            "employee_id" => $id
        );

		$results = "Failed to get employee.";
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }
    
    function getEmployees()
    {
        global $database;
        
        $results = [];
        $sql = "SELECT * FROM employees";
        
        
        $stmt = $database->prepare($sql);
 
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetchALL(PDO::FETCH_ASSOC);               
         }
         
         return ($results);
    }
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/

    function addEvidence($evidence_title, $evidence)
    {
          global $database;
          $results = "";
          $stmt = $database ->prepare("INSERT INTO evidence SET evidence_title = :evidence_title, evidence = :evidence");
          $binds = array(
              ":evidence_title" => $evidence_title,
              ":evidence" => $evidence
              );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }


    function updateEvidence($evidence_title, $evidence, $evidence_id) 
    {
        global $database;

        $stmt = $database ->prepare("UPDATE evidence SET evidence_title = :evidence_title, evidence = :evidence where evidence_id = :evidence_id");
        $results = "";
        $binds = array(
            ":evidence_id" => $evidence_id,
            ":evidence" => $evidence,
            ":evidence_title" => $evidence_title
         );

        $results = 'Failed to update evidence';
        if($stmt->execute($binds) && $stmt->rowCount() > 0) 
        {
            $results = 'The evidence was updated';
        }

        return ($results);
    }
    
    function grabEvidence($id) {
        global $database;
        
        $results = [];
        $sql = "SELECT evidence_title, evidence, evidence_id, case_id from evidence where evidence_id = :evidence_id";
        
        
        $stmt = $database->prepare($sql);
         $binds = array(
            "evidence_id" => $id
        );
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetch(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }   
    
    function getEvidence() 
    {
        global $database;
        
        $results = [];
        $sql = "SELECT * FROM evidence";
        
        
        $stmt = $database->prepare($sql);
 
        if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
             $results = $stmt->fetchALL(PDO::FETCH_ASSOC);               
         }
         
         return ($results);
    }
    
/* -----------------------------------------------------------------------------------------------------------------------------------*/
    

    function checkLogin ($email, $pwd, $position) 
    {
        global $database;
            $results = [];
            $stmt = $database->prepare("SELECT employee_id, email, pwd, position FROM employees where email = :email AND pwd = :pwd AND position = :position;");

            $combine = array(
               ":email" => $email,
               ":pwd" => $pwd,
               ":position" => $position
            );

            if ($stmt->execute($combine) && $stmt->rowCount() > 0) 
            {
                return ("TRUE");

            }

            else 
            {
                return ("FALSE");
            }
            return ($results);
    }

    function getLogin ($email, $pwd) 
    {
        global $database;
            $results = [];
            $stmt = $database->prepare("SELECT employee_id, email, pwd, job_title FROM employees where email = :email AND pwd = :pwd");

            $combine = array(
               ":email" => $email,
               ":pwd" => $pwd
            );

            $results = "Failed to get login information.";
            if ($stmt->execute($combine) && $stmt->rowCount() > 0) 
            {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return ($results);
    }
    
    function getEmployeesWithMessages(){
      global $database;

       $results = [];
       $stmt = $database->prepare("SELECT employees.employee_id AS emp_id, employees.firstname, employees.lastname, messages.* FROM employees LEFT JOIN messages ON messages.sender = employees.employee_id");

       if ( $stmt->execute() && $stmt->rowCount() > 0 ) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }

    function getMessagesForLoggedIn($employee_id){
        global $database;

        $results = [];
        $stmt = $database->prepare("SELECT * FROM messages WHERE employee_id = :employee_id");

        $binds = array(
        ":employee_id" => $employee_id
        );

        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }
    
    function getEmail ($email) 
    {
        global $database;
        $results = [];
        $stmt = $database->prepare("SELECT employee_id, email FROM employees where email = :email;");

        $combine = array(
            ":email" => $email
        );

        if ($stmt->execute($combine) && $stmt->rowCount() > 0) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        else 
        {
            return ("FALSE");
        }
        return ($results);
    }

    function getCases() 
    {
        global $database;

        $result = [];
        $stmt = $database->prepare("SELECT case_id, case_title, case_description, is_active FROM cases");

        if($stmt->execute() && $stmt->rowCount() > 0 ) 
        {
            $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        }

        return ($result);
    }

    function getCasesWithDetails() 
    {
        global $database;

        $result = [];
        $stmt = $database->prepare("SELECT cases.case_id, cases.case_title, cases.case_description, cases.is_active, employees.employee_id, employees.firstname AS employee_first, employees.lastname AS employee_last, employees.job_title, employees.email, employees.phone AS employee_phone, employees.photo, witnesses.witness_id, witnesses.firstname AS witness_first, witnesses.lastname AS witness_last, witnesses.phone AS witness_phone, witness_statement, suspects.suspect_id, suspects.firstname AS suspect_first, suspects.lastname AS suspect_last, suspects.address AS suspect_address, suspects.dob AS suspect_dob, suspects.eye_color, suspects.height, suspects.suspect_weight, suspects.wanted_level, suspects.photo AS suspect_photo, evidence.evidence_id, evidence.evidence_title, evidence.evidence FROM cases LEFT JOIN employees ON cases.case_id = employees.case_id LEFT JOIN witnesses ON cases.case_id = witnesses.case_id LEFT JOIN suspects ON cases.case_id = suspects.case_id LEFT JOIN evidence ON cases.case_id = evidence.case_id");

        if($stmt->execute() && $stmt->rowCount() > 0 ) 
        {
            $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        }

        return ($result);
    }

    function addMessage($recipient, $sender, $content)
    {
          global $database;
          $results = "";
          $stmt = $database ->prepare("INSERT INTO messages SET employee_id = :recipient, sender = :sender, content = :content, time_sent = NOW()");

          $binds = array(
              ":recipient" => $recipient,
              ":sender" => $sender,
              ":content" => $content,
            );

        $results = "Message failed to send.";
        if ( $stmt->execute($binds) && $stmt->rowCount() > 0 ) 
        {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);               
        }

        return ($results);
    }
    
    function searchCases($column, $search)
    {
        global $database;

        $result = [];
        $insert = $database->prepare("SELECT case_id, case_title, case_description, is_active FROM cases WHERE $column LIKE '%$search%'");



        if ($insert->execute() && $insert->rowCount() > 0) {
            $results = $insert->fetchAll(PDO::FETCH_ASSOC);
        }
        return ($results);
    }
    
    function sortCases($column ,$sort)
    {
        global $database;

        $results = [];
        $insert = $database->prepare("SELECT case_id, case_title, case_description, is_active FROM cases ORDER BY $column $sort");

        if ($insert->execute() && $insert->rowCount() > 0) {
            $results = $insert->fetchAll(PDO::FETCH_ASSOC);
        }
        return ($results);
    }

?>
