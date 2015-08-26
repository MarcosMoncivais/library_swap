<?php

    class Author
{
    private $name;
    private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    // Getters and Setters
    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getId()
    {
        return $this->id;
    }

    // Database storage methods
    function save()
    {
        $GLOBALS['DB']->exec(
            "INSERT INTO authors (name) VALUES (
                '{$this->getName()}'
            );"
        );
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }
    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        //$GLOBALS['DB']->exec("DELETE FROM books WHERE course_id = {$this->getId()};");
    }
    // These methods involve the other class
    // function addBook($book)
    // {
    //     $GLOBALS['DB']->exec("INSERT INTO enrollments (student_id, course_id) VALUES (
    //         {$student->getId()},
    //         {$this->getId()}
    //     );");
    // }
    // function getStudents()
    // {
    //     $students_query = $GLOBALS['DB']->query(
    //         "SELECT students.* FROM
    //             courses JOIN enrollments ON (enrollments.course_id = courses.id)
    //                     JOIN students    ON (enrollments.student_id = students.id)
    //          WHERE courses.id = {$this->getId()};
    //         "
    //     );
    //     $matching_students = array();
    //     foreach ($students_query as $student) {
    //         $name = $student['name'];
    //         $enroll_date = $student['enroll_date'];
    //         $id = $student['id'];
    //         $new_student = new Student($name, $enroll_date, $id);
    //         array_push($matching_students, $new_student);
    //     }
    //     return $matching_students;
    // }
    static function getAll()
    {
        $authors_query = $GLOBALS['DB']->query("SELECT * FROM authors;");
        $all_authors = array();
        foreach ($authors_query as $author) {
            $name = $author['name'];
            $id = $author['id'];
            $new_author = new Author($name, $id);
            array_push($all_authors, $new_author);
        }
        return $all_authors;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM authors;");
    }

    // static function find($search_id)
    // {
    //     $found_course = null;
    //     $courses = Course::getAll();
    //     foreach ($courses as $author) {
    //         $course_id = $author->getId();
    //         if ($course_id == $search_id) {
    //             $found_course = $author;
    //         }
    //     }
    //     return $found_course;
    // }
}

?>
