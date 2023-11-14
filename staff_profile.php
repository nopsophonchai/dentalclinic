
<div class="profile-form">
    <h2 class="profile-heading">Staff Profile</h2>
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
            <label>Gender:</label>
            <span><?php echo htmlspecialchars($userDetails['gender']); ?></span>
        </div>
        <div class="form-group">
            <label>Type:</label>
            <span><?php echo htmlspecialchars($userDetails['typeName']); ?></span>
        </div>
        <div class="form-group">
            <label>Date of Birth:</label>
            <span><?php echo htmlspecialchars($userDetails['dateOfBirth']); ?></span>
        </div>
        <div class="form-group">
            <label>Salary:</label>
            <span><?php echo htmlspecialchars($userDetails['salary']); ?></span>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <span><?php echo htmlspecialchars($userDetails['avaStat']); ?></span>
        </div>

        <div class="form-action-group">
            <button type="submit" name="editstaff">Edit</button>
            <button type="submit" name="myprofexittolookup">Return</button>
        </div>
    </form>
</div>
