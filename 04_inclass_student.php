<?php
class Student{
    private string $id;
    private string $name;
    private float $gpa;

    public function __construct(string $id,string $name,float $gpa){
        $this->id = $id;
        $this->name = $name;
        $this->gpa = $gpa;
    }
    public function rank(): string{
        if($this->gpa=3.2) return "gioi";
        if($this->gpa=2.5) return "kha";
        return "trung binh";
    }
}
$list = [
    new Student("SV001","An",3.3),
        new Student("SV002","Binh",2.4),
];
foreach($list as $st){
    echo $st->rank(). "<br>";
}
?>