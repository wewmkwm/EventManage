<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch user ID from session email
$userSql = "SELECT UserID FROM user WHERE Email='$login'";
$userResult = mysqli_query($con, $userSql);
$userRow = mysqli_fetch_assoc($userResult);
$userId = $userRow['UserID'];

// Fetch participant data to check joined events
$participantSql = "SELECT EventID FROM participant WHERE UserID='$userId'";
$participantResult = mysqli_query($con, $participantSql);
$joinedEvents = array();

while ($participantRow = mysqli_fetch_assoc($participantResult)) {
    $joinedEvents[] = $participantRow['EventID'];
}

// Handle search
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch event data from database
if ($search) {
    $sql = "SELECT * FROM event WHERE (EventName LIKE '%$search%' OR Description LIKE '%$search%' OR Organizer LIKE '%$search%')AND Status = 'On-Going'";
} else {
    $sql = "SELECT * FROM event WHERE Status ='On-Going'";
}
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include 'header.html'; 
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        function pop_up_success() {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Successfully registered for the event!',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Continue',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            })
        }

        $(document).ready(function() {
            $(".event-box").click(function() {
                $(this).toggleClass("expanded");
                $(this).find(".event-details").slideToggle();
            });

            $(".join-button").click(function(event) {
                event.stopPropagation(); // Prevent the event-box click event
                var eventId = $(this).data("id");
                var userEmail = "<?php echo $login; ?>";

                if (!userEmail) {
                    alert("You need to be logged in to join an event.");
                    return;
                }

                $.ajax({
                    url: 'register_event.php',
                    type: 'POST',
                    data: {
                        event_id: eventId,
                        user_email: userEmail
                    },
                    success: function(response) {
                        if (response.trim() === "Successfully registered for the event!") {
                            pop_up_success();
                            $(".join-button[data-id='" + eventId + "']").text("Joined").prop("disabled", true);
                        } else {
                            alert(response);
                        }
                    },
                    error: function() {
                        alert("There was an error processing your request. Please try again.");
                    }
                });
            });
        });
    </script>
    <style>
        .event-box {
            cursor: pointer;
            margin-bottom: 20px;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
        }

        .event-box.expanded {
            border-width: 3px;
        }

        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .event-title {
            flex-grow: 1;
            text-align: center;
        }

        .event-details {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php
if (isset($login)) {
    require_once('nav_login.php');
} else {
    require_once('nav.php');
}
?>
<div class="container">
    <h1 class="text-center">Available Events:</h1>
    <form method="POST" action="index.php" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search events" value="<?php echo $search; ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div><br>
        <p style = "color:red; text-align:center;">Click on the event name to look at the event details</P>
    </form>
    <div class="row">
        <?php
        // Dynamically generate event boxes
        while ($row = mysqli_fetch_assoc($result)) {
            $isJoined = in_array($row['EventID'], $joinedEvents);
            echo '<div class="col-md-6">';
            echo '  <div class="rounded-border event-box">';
            echo '      <div class="event-header">';
            echo '          <div class="event-title"><h3>' . $row['EventName'] . '</h3></div>';
            if ($isJoined) {
                echo '          <button class="btn btn-secondary join-button" data-id="' . $row['EventID'] . '" disabled>Joined</button>';
            } else {
                echo '          <button class="btn btn-primary join-button" data-id="' . $row['EventID'] . '">Join</button>';
            }
            echo '      </div>';
            echo '      <div class="event-details">';
            echo '          <h6>' . $row['Description'] . '</h6>';
            echo '          <h6>🏫 Organizer: &nbsp; ' . $row['Organizer'] . '</h6>';
            echo '          <h6>📅 Date: &nbsp; ' . $row['Date'] . '</h6>';
            echo '          <h6>🕐 Time: &nbsp; ' . $row['Time'] . '</h6>';
            echo '          <h6>⌛ Duration: &nbsp; ' . $row['Duration'] . 'hr</h6>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<footer>
    Copyright 2024 © Event Management System
</footer>
</body>
</html>
