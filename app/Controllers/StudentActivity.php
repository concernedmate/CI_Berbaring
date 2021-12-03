<?php

namespace App\Controllers;
use App\Models\StudentActivityModel;

class StudentActivity extends BaseController{

    function __construct(){
        $this->activity = new StudentActivityModel;
    }

    function enroll($c_id){
        $u_id = session()->get('id');
        $enroll_q = 'INSERT INTO student_activity (activity_student_id, started_date, finished_date, user_id, c_id) VALUES (NULL, NULL, NULL, \''.$u_id.'\', \''.$c_id.'\')';
        //$enroll_q = 'INSERT INTO user (user_id, joined_date, name, email, password) VALUES (NULL, \''.date("Y-m-d").'\', \''.$full_name.'\', \''.$email.'\', MD5(\''.$password.'\')) ';
        
        $db = db_connect();
        $db->query($enroll_q);
        return redirect()->to(base_url('homepage/pelajar/1'));
    }

    function startCourse($c_id){
        $u_id = session()->get('id');
        $start_q = 'UPDATE student_activity SET started_date = '.date("Y-m-d").' WHERE c_id = '.$c_id.' AND user_id = '.$u_id;

        $db = db_connect();
        $db->query($start_q);
        return redirect()->to(base_url('course/'.$c_id));
    }

    function page($curr){
        $data = [
            'courses' => $this->activity->getUserStudentActivity(session()->get('id'), $curr),
            'totalCourses' => $this->activity->getUserStudentActivityCount(session()->get('id')),
            'page' => $curr
        ];
        return view('homepage_pelajar.php', $data);
    }
}