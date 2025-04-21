<?php
include('../includes/db.php');
$result = mysqli_query($con, "SELECT * FROM about_us WHERE id = 1");
$row = mysqli_fetch_assoc($result);
?>

<form action="edit_about_us.php" method="POST">
    <textarea name="team_info"><?= $row['team_info'] ?></textarea>
    <textarea name="mission"><?= $row['mission'] ?></textarea>
    <input type="submit" value="Save Changes">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_info = $_POST['team_info'];
    $mission = $_POST['mission'];

    $sql = "UPDATE about_us SET team_info = '$team_info', mission = '$mission' WHERE id = 1";
    mysqli_query($con, $sql);
    header('Location: edit_about_us.php');
}
?>
