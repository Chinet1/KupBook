<?php

$con = mysqli_connect('localhost', 'root', 'qwe123', 'KupBook');

$query_string = "SELECT bk.ID, CONCAT(au.Name, ' ', au.LastName) AS 'Author', bk.Title, bk.Year, bk.Price, pb.Name AS 'Publisher', gn.Name AS 'Genre', bk.Cover FROM `Books` AS bk JOIN `Authors` AS au ON bk.Author = au.ID JOIN `Publishers` AS pb ON bk.Publisher = pb.ID JOIN `Genre` AS gn ON bk.Genre = gn.ID";

$result = mysqli_query($con, $query_string);

