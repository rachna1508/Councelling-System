<?php
ini_set( "display_errors", 0); 
$link = mysqli_connect('localhost', 'root', '') or die('not connecting');
if ($link) {
    //connected to sql
    mysqli_query($link, "create database if not exists councelling");
    mysqli_select_db($link, "councelling");
    $tables = Array(
        "create table student( sid int primary key AUTO_INCREMENT, name TEXT, username text, father text, mother text, dob date, gender varchar(10), mail text, address text, city text, state varchar(60), pin int not null, mobile varchar(12) ) ",
        "create table institute( Iid int primary key AUTO_INCREMENT, name text not null, username text not null, rank int,mail varchar(200) unique, website text, address text, city text not null, state text not null, pincode int not null, contact varchar(14) not null, about text, vision text, NAAC_grade varchar(5), enterance varchar(10) not null default 'NO' ) ",
        "create table if not exists st_login(username varchar(200) primary key,password text)",
        "create table if not exists inst_login(inst_username varchar(200) primary key,password text)",
        "create table if not exists career_obj(sid int,objective text,FOREIGN KEY(sid) references student(sid))",
        "create table if not exists achievements(sid int,achieve text,FOREIGN KEY(sid) references student(sid)) ",
        "create table if not exists qualifications(sid int,qualification text,FOREIGN KEY(sid) references student(sid)) ",
        "create table if not exists centers(Iid int,center text,FOREIGN KEY(Iid) references institute(Iid))",
        "create table if not exists awards(Iid int,award text,FOREIGN KEY(Iid) references institute(Iid))",
        "create table if not exists programs(Iid int,level text,program text,FOREIGN KEY(Iid) references institute(Iid))",
        "create table if not exists events(eid int PRIMARY key AUTO_INCREMENT,Iid int,type varchar(100) not null,heading text not null,description text,deadline date,FOREIGN KEY(Iid) REFERENCES institute(Iid))",
        "create table if not exists attende(aid int PRIMARY KEY AUTO_INCREMENT,sid int,eid int,time date,FOREIGN key(sid) REFERENCES student(sid), FOREIGN key(eid) REFERENCES events(eid))"
    );
    //creating table

    foreach ($tables as $query)
        mysqli_query($link, $query);
}
 else {
    echo '<script>alert("Error in initilizing database")</script>';
}
?>