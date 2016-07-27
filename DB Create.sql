drop database minotaurImageboard;

create database minotaurImageboard;
use minotaurImageboard;

create table site
(
siteID int NOT NULL AUTO_INCREMENT primary key
) engine = innodb;

create table board
(
boardID int NOT NULL AUTO_INCREMENT primary key,
boardName varchar(25),
description varchar(250),
siteID int,
foreign key (siteID) references site (siteID)
) engine = innodb;

create table thread
(
threadID int NOT NULL AUTO_INCREMENT primary key,
boardID int,
lastUpdated timestamp,
locked boolean,
lockedBy varChar(30),
foreign key (boardID) references board (boardID)
) engine = innodb;

create table post
(
postID int NOT NULL AUTO_INCREMENT primary key,
timeOfPost	timestamp,
postName	varChar(20),
postSubject varChar(20),
image MEDIUMBLOB,
imageName varchar(40),
postText varChar(500),
threadID int ,
foreign key (threadID) references thread (threadID)
) engine = innodb;

create table newsStory
(
newsID int  NOT NULL AUTO_INCREMENT primary key,
title varchar(30),
author varchar(30),
createdOn timestamp,
body varchar(1000),
siteID int,
foreign key (siteID) references site(siteID)
) engine = innodb;

create table moderator
(
modID int  NOT NULL AUTO_INCREMENT primary key,
username varchar(30) unique,
password varchar(30),
name varchar(30),
siteID int,
foreign key (siteID) references site(siteID)
) engine = innodb;

delimiter $$

drop trigger if exists postNumIncr_AI$$

create trigger postNumIncr_AI
after insert on post
for each row 
begin
    update thread set  lastUpdated = now() where thread.threadID = (SELECT threadID FROM post ORDER BY postID DESC LIMIT 1 );
end $$
delimiter ;

insert into site values(null);

insert into board values(null,"General Game Discussion", "Board for general discussion of the game", 1);
insert into board values(null,"Level Hints" , "Don't know how to beat a level? Ask for help here.", 1);
insert into board values(null,"Off topic", "Talk about everything and anything that isn't related to the game", 1);

insert into thread values( null,1, now(),false, null);
insert into thread values( null,2, now(),false, null);
insert into thread values(null, 2, now(),false, null);
insert into thread values(null, 3, now(),true, "Name Doe");

insert into post values(null,now(), null, "post title", null, null, "Hi! how do I do the thing?" ,1);
insert into post values(null,now(), "Anonymous", "Subject!!!!", null,null, "Hi! how do I do the thing?" ,2);
insert into post values( null,now(), "FIXANONYMOUS", "three", null, null, "everything and anything" ,2);

insert into newsStory values(null, "Welcome to the new site", "Name Doe", now(), "aasdfadfsafdsadfs asdsadfafds afds aagregfe new site hi",1);
insert into newsStory values(null, "Site is dead", "Name Doe", now(), "  afds hi",1);
insert into newsStory values(null, "Site is alive", "Jane Doe", now(), "  afds hi",1);

insert into moderator values(null, "usern4me", "password1", "Name Doe",1);
insert into moderator values(null, "us67me", "password66664", "Jane Doe",1);

SELECT image FROM post WHERE postID=54;

SELECT image FROM post WHERE postID=55 LIMIT 1;

SELECT * FROM thread WHERE thread.lastUpdated >= (DATE_SUB(now(), INTERVAL 12 Hour));

select * from 
(select board.boardID as 'boardID', count(postID) as 'postCount24' from post inner join thread on post.threadID = thread.threadID inner join board on thread.boardID = board.boardID WHERE thread.lastUpdated >= (DATE_SUB(now(), INTERVAL 12 Hour)) group by board.boardID) as a
right join
(select * from board) as b
on a.boardID = b.boardID;

SELECT a.boardID, a.boardName, a.description, a.threadCount, b.postCount, c.postCount24 from
	(select thread.boardID as 'boardID', boardName, description ,count(1) as 'threadCount' 
    from thread 
    inner join board 
    on thread.boardID = board.boardID 
    group by boardID
    ) as a
join
	(select board.boardID as 'boardID', count(1) as 'postCount' 
    from post 
    inner join thread 
    on post.threadID = thread.threadID 
    inner join board 
    on thread.boardID = board.boardID 
    group by board.boardID
    ) as b
on a.boardID = b.boardID
left join
	(select board.boardID as 'boardID', count(postID) as 'postCount24' 
    from post 
    inner join thread 
    on post.threadID = thread.threadID 
    inner join board
    on thread.boardID = board.boardID 
    WHERE thread.lastUpdated >= (DATE_SUB(now(), INTERVAL 12 Hour)) 
    group by board.boardID
    ) as c
on b.boardID = c.boardID
order by board.boardID;

select boardName, description from board join thread on board.boardID = thread.boardID where threadID =2;

select * from thread where boardID=2 order by lastUpdated desc;
SELECT postID, image, imageName FROM post where image is not null;
select * from site;
select * from board;
select * from thread;
select * from post;
select * from newsStory;