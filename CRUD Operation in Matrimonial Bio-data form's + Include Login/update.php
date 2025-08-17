<?php
session_start();
include('server.php');

// Check if ID parameter exists
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "No biodata ID specified for update.";
    $_SESSION['message_type'] = "error";
    header("Location: read.php");
    exit();
}

$id = $_GET['id'];

// Fetch existing biodata
$query = "SELECT * FROM biodata WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['message'] = "No biodata found with that ID.";
    $_SESSION['message_type'] = "error";
    header("Location: read.php");
    exit();
}

$biodata = $result->fetch_assoc();

// Convert comma-separated values to arrays for checkboxes
$languages = explode(',', $biodata['languages']);
$hobbies = explode(',', $biodata['hobbies']);

// Close statement
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Update Matrimonial Biodata</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
        <?php 
          echo $_SESSION['message']; 
          unset($_SESSION['message']);
          unset($_SESSION['message_type']);
        ?>
      </div>
    <?php endif; ?>
    
    <form id="biodata-form" action="update_logic.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="hidden" name="action" value="update">
      
      <div class="form-header">
        <h1>Update Matrimonial Biodata</h1>
        <p>Update your biodata information</p>
      </div>

      <div class="input-control">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" 
               value="<?php echo htmlspecialchars($biodata['fullName']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" 
               value="<?php echo htmlspecialchars($biodata['email']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" 
               value="<?php echo htmlspecialchars($biodata['dob']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Gender</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="male" name="gender" value="Male" 
                  <?php echo ($biodata['gender'] == 'Male') ? 'checked' : ''; ?> required />
            <label for="male">Male</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="female" name="gender" value="Female"
                  <?php echo ($biodata['gender'] == 'Female') ? 'checked' : ''; ?> />
            <label for="female">Female</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="other" name="gender" value="Other"
                  <?php echo ($biodata['gender'] == 'Other') ? 'checked' : ''; ?> />
            <label for="other">Other</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Marital Status</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="unmarried" name="marital" value="Unmarried"
                  <?php echo ($biodata['marital'] == 'Unmarried') ? 'checked' : ''; ?> required />
            <label for="unmarried">Unmarried</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="divorced" name="marital" value="Divorced"
                  <?php echo ($biodata['marital'] == 'Divorced') ? 'checked' : ''; ?> />
            <label for="divorced">Divorced</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="widowed" name="marital" value="Widowed"
                  <?php echo ($biodata['marital'] == 'Widowed') ? 'checked' : ''; ?> />
            <label for="widowed">Widowed</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="blood">Blood Group</label>
        <select id="blood" name="blood" required>
          <option value="">-- Select Blood Group --</option>
          <option value="A+" <?php echo ($biodata['blood'] == 'A+') ? 'selected' : ''; ?>>A+</option>
          <option value="A-" <?php echo ($biodata['blood'] == 'A-') ? 'selected' : ''; ?>>A-</option>
          <option value="B+" <?php echo ($biodata['blood'] == 'B+') ? 'selected' : ''; ?>>B+</option>
          <option value="B-" <?php echo ($biodata['blood'] == 'B-') ? 'selected' : ''; ?>>B-</option>
          <option value="AB+" <?php echo ($biodata['blood'] == 'AB+') ? 'selected' : ''; ?>>AB+</option>
          <option value="AB-" <?php echo ($biodata['blood'] == 'AB-') ? 'selected' : ''; ?>>AB-</option>
          <option value="O+" <?php echo ($biodata['blood'] == 'O+') ? 'selected' : ''; ?>>O+</option>
          <option value="O-" <?php echo ($biodata['blood'] == 'O-') ? 'selected' : ''; ?>>O-</option>
        </select>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="height">Height (cm)</label>
        <input type="number" id="height" name="height" placeholder="Enter your height" 
               value="<?php echo htmlspecialchars($biodata['height']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="weight">Weight (kg)</label>
        <input type="number" id="weight" name="weight" placeholder="Enter your weight" 
               value="<?php echo htmlspecialchars($biodata['weight']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Body Color</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="fair" name="color" value="Fair"
                  <?php echo ($biodata['color'] == 'Fair') ? 'checked' : ''; ?> required />
            <label for="fair">Fair</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="medium" name="color" value="Medium"
                  <?php echo ($biodata['color'] == 'Medium') ? 'checked' : ''; ?> />
            <label for="medium">Medium</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="dark" name="color" value="Dark"
                  <?php echo ($biodata['color'] == 'Dark') ? 'checked' : ''; ?> />
            <label for="dark">Dark</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="family">Family Members</label>
        <input type="number" id="family" name="family" placeholder="Number of family members" 
               value="<?php echo htmlspecialchars($biodata['family']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="education">Education</label>
        <input type="text" id="education" name="education" placeholder="Your highest education" 
               value="<?php echo htmlspecialchars($biodata['education']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="profession">Profession</label>
        <input type="text" id="profession" name="profession" placeholder="Your profession" 
               value="<?php echo htmlspecialchars($biodata['profession']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label>Languages Known</label>
        <div class="checkbox-group">
          <div class="checkbox-option">
            <input type="checkbox" id="english" name="languages[]" value="English"
                  <?php echo (in_array('English', $languages)) ? 'checked' : ''; ?> />
            <label for="english">English</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="hindi" name="languages[]" value="Hindi"
                  <?php echo (in_array('Hindi', $languages)) ? 'checked' : ''; ?> />
            <label for="hindi">Hindi</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="bengali" name="languages[]" value="Bengali"
                  <?php echo (in_array('Bengali', $languages)) ? 'checked' : ''; ?> />
            <label for="bengali">Bengali</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="tamil" name="languages[]" value="Tamil"
                  <?php echo (in_array('Tamil', $languages)) ? 'checked' : ''; ?> />
            <label for="tamil">Tamil</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="telugu" name="languages[]" value="Telugu"
                  <?php echo (in_array('Telugu', $languages)) ? 'checked' : ''; ?> />
            <label for="telugu">Telugu</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="otherLang" name="languages[]" value="Other"
                  <?php echo (in_array('Other', $languages)) ? 'checked' : ''; ?> />
            <label for="otherLang">Other</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label>Hobbies</label>
        <div class="checkbox-group">
          <div class="checkbox-option">
            <input type="checkbox" id="reading" name="hobbies[]" value="Reading"
                  <?php echo (in_array('Reading', $hobbies)) ? 'checked' : ''; ?> />
            <label for="reading">Reading</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="music" name="hobbies[]" value="Music"
                  <?php echo (in_array('Music', $hobbies)) ? 'checked' : ''; ?> />
            <label for="music">Music</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="traveling" name="hobbies[]" value="Traveling"
                  <?php echo (in_array('Traveling', $hobbies)) ? 'checked' : ''; ?> />
            <label for="traveling">Traveling</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="sports" name="hobbies[]" value="Sports"
                  <?php echo (in_array('Sports', $hobbies)) ? 'checked' : ''; ?> />
            <label for="sports">Sports</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="cooking" name="hobbies[]" value="Cooking"
                  <?php echo (in_array('Cooking', $hobbies)) ? 'checked' : ''; ?> />
            <label for="cooking">Cooking</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="photography" name="hobbies[]" value="Photography"
                  <?php echo (in_array('Photography', $hobbies)) ? 'checked' : ''; ?> />
            <label for="photography">Photography</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="nationality">Nationality</label>
        <input type="text" id="nationality" name="nationality" placeholder="Your nationality" 
               value="<?php echo htmlspecialchars($biodata['nationality']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Your phone number" 
               value="<?php echo htmlspecialchars($biodata['phone']); ?>" required />
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" placeholder="Your full address" required><?php echo htmlspecialchars($biodata['address']); ?></textarea>
        <div class="error"></div>
      </div>
      <!-- Add these fields before the form-actions div -->

<div class="input-control">
  <label for="profileImage">Update Profile Image (JPEG/PNG)</label>
  <?php if (!empty($biodata['profile_image'])): ?>
    <div class="current-file">
      <img src="<?php echo htmlspecialchars($biodata['profile_image']); ?>" class="current-profile-img" alt="Current Profile">
      <span>Current: <?php echo basename($biodata['profile_image']); ?></span>
    </div>
  <?php endif; ?>
  <input type="file" id="profileImage" name="profileImage" accept="image/jpeg, image/png">
  <div class="error"></div>
</div>

<div class="input-control">
  <label for="biodataPdf">Update Biodata PDF</label>
  <?php if (!empty($biodata['biodata_pdf'])): ?>
    <div class="current-file">
      <a href="<?php echo htmlspecialchars($biodata['biodata_pdf']); ?>" target="_blank" class="pdf-link">
        <i class="fas fa-file-pdf"></i> Current PDF: <?php echo basename($biodata['biodata_pdf']); ?>
      </a>
    </div>
  <?php endif; ?>
  <input type="file" id="biodataPdf" name="biodataPdf" accept=".pdf">
  <div class="error"></div>
</div>

      <div class="form-actions">
  <button type="submit" name="update" class="btn btn-primary">
    <i class="fas fa-save"></i> Update Biodata
  </button>
  <a href="read.php?id=<?php echo $id; ?>" class="btn btn-secondary">
    <i class="fas fa-times"></i> Cancel
  </a>
</div>
    </form>
  </div>
</body>
</html>