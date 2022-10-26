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
                'name' => 'Management'
            ],
            [
                'name' => 'Performance'
            ],
            [
                'name' => 'Farm'
            ],
            [
                'name' => 'Support'
            ],
            [
                'name' => 'Push'
            ]
        ];
        $cats = [];
        $i = 0;

        foreach($qcat as $cat)
        {
            $cats[$i] = QCategory::create($cat);
            $i++;
        }

        //factory management questions
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
            Question::create($q);

        $departments = [
            [
                'name' => 'College of Communication and Internet Computing Technology',
                'abbre' => 'CCICT'
            ],
            [
                'name' => 'College of Arts and Sciences',
                'abbre' => 'CAS'
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

        $faculty = [
            [
                'type' => 3,
                'name' => 'Jose Marie Garcia',
                'email' => 'jose@gmail.com',
                'password' => bcrypt('amores15')
            ],
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
            ],
            [
                'type' => 3,
                'name' => 'Dindo Logpit',
                'email' => 'dindo@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,
                'name' => 'Starzy Bicare Baluarte-Bacus',
                'email' => 'starzy@gmail.com',
                'password' => bcrypt('amores15')
            ],
            [
                'type' => 3,
                'name' => 'Joey Sayson',
                'email' => 'joey@gmail.com',
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
        }/* 
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
        } */
        //Factory courses
        $courses = [
            [
                'department_id' => 1,
                'name' => 'Bachelor of Science in Information Technology',
                'abbre' => 'BSIT'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Science in Computer Science',
                'abbre' => 'BSCS'
            ],
            [
                'department_id' => 1,
                'name' => 'Bachelor of Science in Computer Technology',
                'abbre' => 'BSCompTech'
            ]
        ];

        foreach($courses as $c)
            Course::create($c);

        $subjects = [
            /* [
                'course_id' => 1,
                'code' => 'GEC-RPH',
                'name' => 'Readings in Philippine History'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-MMW',
                'name' => 'Mathematics in the Modern Word'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-TEM',
                'name' => 'The Entrepreneurial Mind'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 111',
                'name' => 'Introduction to Computing'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 112',
                'name' => 'Programming 1 (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 112 L',
                'name' => 'Programming 1 (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 1',
                'name' => 'Multimedia'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-RPH',
                'name' => 'Readings in Philippine History'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 1',
                'name' => 'Physical Education 1'
            ],
            [
                'course_id' => 1,
                'code' => 'NSTP 1',
                'name' => 'National Service Training Program 1'
            ], //2nd sem 1st year
            [
                'course_id' => 1,
                'code' => 'GEC-PC',
                'name' => 'Purposive Communication'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-STS',
                'name' => 'Science, Technology and Society'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-US',
                'name' => 'Understanding the Self'
            ],
            [
                'course_id' => 1,
                'code' => 'GEE-RRES',
                'name' => 'Religions, Religious Experiences and Spirituality'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 123',
                'name' => 'Programming 2 (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 123 L',
                'name' => 'Programming 2 (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 121',
                'name' => 'Discrete Mathematics'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 2',
                'name' => 'Digital Logic Design'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 2',
                'name' => 'Physical Education 2'
            ],
            [
                'course_id' => 1,
                'code' => 'NSTP 2',
                'name' => 'National Service Training Program 2'
            ],//2nd year
            [
                'course_id' => 1,
                'code' => 'GEC-E',
                'name' => 'Ethics'
            ],
            [
                'course_id' => 1,
                'code' => 'GEE-ES',
                'name' => 'Environmental Science'
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-LWR',
                'name' => 'Life and Works of Rizal'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 212',
                'name' => 'Quantitative Methods (Modeling & Simulation)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 214',
                'name' => 'Data Structures and Algorithms (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 214 L',
                'name' => 'Data Structures and Algorithms (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 1',
                'name' => 'Professional Elective 1'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 2',
                'name' => 'Professional Elective 2'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 3',
                'name' => 'Physical Education 3'
            ],//2nd sem 
            [
                'course_id' => 1,
                'code' => 'GEC-TCW',
                'name' => 'The Contemporary World'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 223',
                'name' => 'Integrative Programming and Technologies 1'
            ],
            [
                'course_id' => 1,
                'code' => 'PC 224',
                'name' => 'Networking 1'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 225',
                'name' => 'Information Management (Lec)'
            ],
            [
                'course_id' => 1,
                'code' => 'CC 225 L',
                'name' => 'Information Management (Lab)'
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 3',
                'name' => 'Professional Elective 3'
            ],
            [
                'course_id' => 1,
                'code' => 'AP 3',
                'name' => 'ASP.NET'
            ],
            [
                'course_id' => 1,
                'code' => 'PE 4',
                'name' => 'Physical Education 4'
            ],//3rd year */
            [
                'course_id' => 1,
                'code' => 'GEC-KAF',
                'name' => 'Komunikasyon sa Akademikong Filipino',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 315',
                'name' => 'Networking 2 (Lec)',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 315 L',
                'name' => 'Networking 2 (Lab)',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 316',
                'name' => 'Systems Integration and Arcitecture 1',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 317',
                'name' => 'Introduction to Human Computer Interaction',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 318',
                'name' => 'Database Management Systems',
                'year_level' => 3,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 319',
                'name' => 'Applications Development and Emerging Technologies',
                'year_level' => 3,
                'semester' => 1
            ],//2nd sem
            [
                'course_id' => 1,
                'code' => 'GEC-AA',
                'name' => 'Art Appreciation',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'GEC-PPTP',
                'name' => 'Pagbasa at Pagsulat Tungo sa Pananaliksik',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 329',
                'name' => 'Capstone Project and Research 1 (Technopreneurship 1)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3210',
                'name' => 'Social and Professional Issues',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3211',
                'name' => 'Information Assurance and Security 1 (Lec)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'PC 3211 L',
                'name' => 'Information Assurance and Security 1 (Lab)',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'AP 4',
                'name' => 'iOS Mobile Application Development Cross-Platform',
                'year_level' => 3,
                'semester' => 2
            ],
            [
                'course_id' => 1,
                'code' => 'AP 5',
                'name' => 'Technology and the Application of the Internet of Things',
                'year_level' => 3,
                'semester' => 2
            ],//4th year
            [
                'course_id' => 1,
                'code' => 'PC 4112',
                'name' => 'Information and Assurance Security 2 (Lec)',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4112 L',
                'name' => 'Information and Assurance Security 2 (Lab)',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4113',
                'name' => 'Systems Administration and Maintenance',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'P Elec 4',
                'name' => 'Professional Elective 4',
                'year_level' => 4,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'code' => 'PC 4114',
                'name' => 'Capstone Project and Research 2 (Technopreneurship 2)',
                'year_level' => 4,
                'semester' => 1
            ]
        ];

        foreach($subjects as $sub)
            Subject::create($sub);
        
        /* //create four courses in one department
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
        } */
        /* //create 20 students
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
        } */
        //create current period
        Period::create([
            'description' => '1st Semester 2022-2023'
        ]);
    }
}