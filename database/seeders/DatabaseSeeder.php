<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Admin;
use App\Models\Block;
use App\Models\QType;
use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Attribute;
use App\Models\QCategory;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::factory()->create([
            'type' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('amores15')
        ]);

        Admin::create([
            'user_id' => $admin->id
        ]);

        //Factory question types
        $qtype = [
            [
                'name' => 'Quantitative'
            ],
            [
                'name' => 'Qualitative'
            ]
        ];
        foreach($qtype as $type)
            QType::create($type);

        $qcat = [
            [
                'name' => 'QCategory1'//'Management'
            ],
            [
                'name' => 'QCategory2'//'Performance'
            ],
            [
                'name' => 'QCategory3'//'Farm'
            ],
            [
                'name' => 'QCategory4'//'Support'
            ],
            [
                'name' => 'QCategory5'//'Push'
            ]
        ];
        $cats = [];
        $i = 0;

        foreach($qcat as $cat)
        {
            $cats[$i] = QCategory::create($cat);
            //create 4 questions on category created
            for($j = 0; $j < 4; $j++)
            {
                Question::factory()->create([
                    'q_type_id' => 1,
                    'q_category_id' => $cats[$i]->id,
                    'type' => 4
                ]);
            }
            $i++;
        }

        /* //factory management questions
        $questions = [
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives reasonable course/subject assignments',
                'keyword' => 'reasonable',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'earns appreciation and kind attention from the students',
                'keyword' => 'appreciative',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives orientation about the subject and how the students are evaluated',
                'keyword' => 'briefs subject',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 1,
                'sentence' => 'gives test and/or projects which are within the objectives of the course',
                'keyword' => 'test/projects given was discussed',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'shows concern in assisting the students',
                'keyword' => 'helps students',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'shows sympathetic insight into students’ feelings',
                'keyword' => 'sympathetic',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'checks and records test papers/term papers promptly',
                'keyword' => 'dili tingubon check',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 2,
                'sentence' => 'is on time and regular in meeting the class',
                'keyword' => 'punctual',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'assigns fair subject/course requirements',
                'keyword' => 'fair subject/course requirements',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'sustains the attention of the class for the whole period',
                'keyword' => 'class is listening',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'presents lesson clearly, methodically, and substantially',
                'keyword' => 'clear presentation of lessons',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 3,
                'sentence' => 'motivates the students to learn',
                'keyword' => 'motivator',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'facilitates learning with the application of appropriate educational methods and techniques',
                'keyword' => 'teaching strategy',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'shows mastery of the lesson',
                'keyword' => 'mastery of lesson',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'is prepared for the class',
                'keyword' => 'prepared',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 4,
                'sentence' => 'inspires students’ self-reliance in their quest for knowledge',
                'keyword' => 'make students eager to learn',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'knows when the students have difficulty understanding the lesson and finds ways to make it easy',
                'keyword' => 'knows the limit of students understanding',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'integrates values into the lesson',
                'keyword' => 'values oriented',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'Speaks the language of instruction (English or Filipino) clearly and fluently',
                'keyword' => 'speaks language beingu used clearly',
                'type' => 4
            ],
            [
                'q_type_id' => 1,
                'q_category_id' => 5,
                'sentence' => 'delivers thought provoking questions',
                'keyword' => 'makes student think more',
                'type' => 4
            ]
        ];
        foreach($questions as $q)
            Question::create($q); */

        $departments = [
            [
                'name' => 'College of Communication and Internet Computing Technology',
                'abbre' => 'CCICT'
            ],
            [
                'name' => 'College of ICT',
                'abbre' => 'CCICT'
            ],
            [
                'name' => 'College of Technology',
                'abbre' => 'CoT'
            ],
            [
                'name' => 'College of Engineering',
                'abbre' => 'CoE'
            ],
            [                    
                'name' => 'College of Education',
                'abbre' => 'CoEd'
            ]
        ];

        foreach($departments as $dept)
            Department::create($dept);

        /* $faculty = [
            [
                'type' => 3,
                'name' => 'Bell Campanilla',
                'email' => 'bell@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,
                'name' => 'Pet Andrew Nacua',
                'email' => 'pet@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,
                'name' => 'Noreen Fuentes',
                'email' => 'noreen@gmail.com',
                'password' => bcrypt('amores15')
            ]
        ]; 

        foreach($faculty as $facs)
        {
            $user = User::factory()->create($facs);

            if($user->type == 'faculty')
            {
                $fac = Faculty::factory()->create([
                    'name' => $user->name,
                    'user_id' => $user->id,
                    'department_id' => 1
                ]);
                //create the attributes
                foreach($cats as $cat)
                {
                    Attribute::create([
                        'faculty_id' => $fac->user_id,
                        'q_category_id' => $cat->id,
                        'points' => random_int(20, 90)
                    ]);
                }
            }
        } */
        //create 5 faculty
        for($i = 0; $i < 5; $i++)
        {
            //create user
            $user = User::factory()->create([
                'type' => 3,
                'email' => 'faculty' . Faculty::count() + 1 . '@gmail.com'
            ]);
            //create faculty
            $fac = Faculty::factory()->create([
                'name' => $user->name,
                'user_id' => $user->id,
                'department_id' => 1
            ]);
            //create the attributes
            foreach($cats as $cat)
            {
                Attribute::create([
                    'faculty_id' => $fac->user_id,
                    'q_category_id' => $cat->id,
                    'points' => random_int(20, 90)
                ]);
            }
        }
        
        //create four courses in one department
        for($i = 0; $i < 4; $i++)
        {
            $course = Course::factory()->create([
                'department_id' => 1
            ]);
            //create 1 to 3 subjects from course created
            for($j = 0; $j < random_int(1, 3); $j++)
            {
                Subject::factory()->create([
                    'course_id' => $course->id
                ]);
            }
        }
        //create 20 students
        for($i = 0; $i < 20; $i++)
        {
            //create user
            $user = User::factory()->create([
                'type' => 4,
                'email' => 'student' . Student::count() + 1 . '@gmail.com'
            ]);
            //create faculty
            Student::factory()->create([
                'name' => $user->name,
                'user_id' => $user->id,
                'course_id' => random_int(1, Course::count())
            ]);
        }
        //create current period
        Period::create([
            'description' => '1st Semester 2022-2023'
        ]);
    }
}