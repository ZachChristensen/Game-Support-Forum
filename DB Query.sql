use minotaurimageboard;
-- One thread
select * from post where threadID = 2;


-- front page
select * from post inner join thread on post.threadID = thread.threadID where not exists  (SELECT thread.threadID FROM thread ORDER BY lastUpdated DESC LIMIT 1) group by post.postID;

-- insert post
insert into post values(null,now(), null, "hi", null, "SAMMPLE TEEEEEEEEEXT " ,2);

-- update board description
update board set description = "Testing change of board descriptione" where boardID = 1;

-- delete thread
set @theThread = 1;
delete from post where threadID = @theThread;
delete from thread where threadID = @theThread;

-- see news by a moderator
select moderator.modID,moderator.name,newsstory.title,createdon 
from moderator 
inner join site on moderator.siteID = site.siteID 
inner join newsstory on newsstory.siteID = site.siteID 
where moderator.name = newsstory.author and
newsstory.author = "Jane Doe"
order by newsstory.title desc;

-- count news by a moderator
select moderator.modID,moderator.name, count(newsstory.title) as NumberOfArticles
from moderator 
inner join site on moderator.siteID = site.siteID 
inner join newsstory on newsstory.siteID = site.siteID 
where moderator.name = newsstory.author
group by moderator.modID
order by moderator.modID;


-- create or replace view complex as
-- select * from

-- C O M P L E X count of locked threads by moderator id in past 
select modID, name, count(thread.threadID) as numLockedThreads, count(distinct board.boardID) as numBoardsActive
from site
inner JOIN  moderator 
on moderator.siteID = site.siteID 
inner join board 
on site.siteID = board.siteID
inner join thread 
on thread.boardID = board.boardID
where thread.locked = true 
and thread.lockedBy = moderator.name
and (thread.lastUpdated >= DATE_SUB(CURDATE(), INTERVAL 7 DAY))
group by moderator.modID
order by lockedBy desc;