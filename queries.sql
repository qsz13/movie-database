
-- the names of all the actors in the movie 'Die Another Day'
SELECT CONCAT(first, ' ', last) FROM Actor where id IN (SELECT aid FROM MovieActor where mid =(SELECT id FROM Movie WHERE title = "Die Another Day"));

-- the count of all the actors who acted in multiple movies
SELECT count(aid) FROM (SELECT aid FROM MovieActor group by aid HAVING count(aid) >1) as S;

-- select actor name and director name who have cooperate more than once
SELECT CONCAT(Actor.first,' ', Actor.last), CONCAT(Director.first,' ', Director.last) FROM Actor join (SELECT aid, did from MovieActor join MovieDirector on MovieActor.`mid` = MovieDirector.`mid` group by aid,did having count(*) > 1) AS S join Director on S.aid = Actor.id and S.did = Director.id;
