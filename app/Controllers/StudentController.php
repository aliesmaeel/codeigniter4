<?php

namespace App\Controllers;

use App\Models\Student;
use CodeIgniter\Test\Fabricator;
use Faker\Factory as Faker;



class StudentController extends BaseController
{

    public function index(){

        $students=new Student();
        $data['students']=$students->findAll();

        return view('students/index',$data);
    }

    public function create(){
        return view('students/create');
    }

    public function store(){
        $students=new Student();
        $data=[
            'name'=>$this->request->getPost('name'),
            'email'=>$this->request->getPost('email'),
            'phone'=>$this->request->getPost('phone'),
            'course'=>$this->request->getPost('course'),
        ];

        $students->save($data);
        return redirect()->to('/students')->with('message','Student Inserted Successfully');
    }

    public function edit($id=null){
        $student=new Student();
        $data['student']=$student->find($id);
        return view('students/student',$data);

    }


    public function update($id){
        $student=new Student();
        $student->find($id);
        $data=[
            'name'=>$this->request->getPost('name'),
            'email'=>$this->request->getPost('email'),
            'phone'=>$this->request->getPost('phone'),
            'course'=>$this->request->getPost('course'),
        ];
        $student->update($id,$data);
        return redirect()->to('/students')->with('message','Student Updated Successfully');

    }

    public function delete($id){
        $student=new Student();
        $student->delete($id);
        return redirect()->to('/students')->with('message','Student Deleted Successfully');
    }

    public function ajaxDelete($id){
        $student=new Student();
        $student->delete($id);
        return;
    }

    public function createRandom(){

        $faker = Faker::create();
        $student = new Student();
        $data=[
            'name'=>$faker->firstName,
            'email'=>$faker->email,
            'phone'=>$faker->phoneNumber,
            'course'=>$faker->lastName,
        ];

        $student->save($data);

        return redirect()->to('/students')->with('message', 'Fake Student Inserted Successfully');
    }

}