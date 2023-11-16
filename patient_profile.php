
<div class="profile-form">
    <h2 class="profile-heading">Patient Profile</h2>
    <form action="dentalIndex.php" method="post">
        <input type="hidden" name="formType" value="viewprofile" />
        
        <div class="form-group">
            <label>First Name:</label>
            <span><?php echo htmlspecialchars($userDetails['firstName']); ?></span>
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <span><?php echo htmlspecialchars($userDetails['lastName']); ?></span>
        </div>
        <div class="form-group">
            <label>National ID:</label>
            <span><?php echo htmlspecialchars($userDetails['nationalID']); ?></span>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <span><?php echo htmlspecialchars($userDetails['gender']); ?></span>
        </div>
        <div class="form-group">
            <label>Date of Birth:</label>
            <span><?php echo htmlspecialchars($userDetails['dateOfBirth']); ?></span>
        </div>
        <div class="form-group">
            <label>Telephone:</label>
            <span><?php echo htmlspecialchars($userDetails['telephone']); ?></span>
        </div>
        <div class="form-group">
            <label>Address:</label>
            <span><?php echo htmlspecialchars($userDetails['houseAddress']); ?></span>
        </div>

        <div class="form-action-group">
            <button type="submit" name="editpatient">Edit</button>
            <button type="submit" name="myprofexittolookup">Return</button>
        </div>
    </form>
</div>
