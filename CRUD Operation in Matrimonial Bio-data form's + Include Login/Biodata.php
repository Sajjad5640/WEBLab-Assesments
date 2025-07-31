


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <title>Matrimonial Biodata</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container" >

  <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
        <?php 
          echo $_SESSION['message']; 
          unset($_SESSION['message']);
          unset($_SESSION['message_type']);
        ?>
      </div>
    <?php endif; ?>
    <form id="biodata-form" action="model.php" method="post">
      <div class="form-header">
        <h1>Matrimonial Biodata</h1>
        <p>Find your perfect life partner</p>
      </div>

      <div class="input-control">
        <label for="fullName">Full Name</label>
        <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Gender</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="male" name="gender" value="Male" required />
            <label for="male">Male</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="female" name="gender" value="Female" />
            <label for="female">Female</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="other" name="gender" value="Other" />
            <label for="other">Other</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Marital Status</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="unmarried" name="marital" value="Unmarried" required />
            <label for="unmarried">Unmarried</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="divorced" name="marital" value="Divorced" />
            <label for="divorced">Divorced</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="widowed" name="marital" value="Widowed" />
            <label for="widowed">Widowed</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="blood">Blood Group</label>
        <select id="blood" name="blood" required>
          <option value="">-- Select Blood Group --</option>
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
        </select>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="height">Height (cm)</label>
        <input type="number" id="height" name="height" placeholder="Enter your height" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="weight">Weight (kg)</label>
        <input type="number" id="weight" name="weight" placeholder="Enter your weight" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label>Body Color</label>
        <div class="radio-group">
          <div class="radio-option">
            <input type="radio" id="fair" name="color" value="Fair" required />
            <label for="fair">Fair</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="medium" name="color" value="Medium" />
            <label for="medium">Medium</label>
          </div>
          <div class="radio-option">
            <input type="radio" id="dark" name="color" value="Dark" />
            <label for="dark">Dark</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="family">Family Members</label>
        <input type="number" id="family" name="family" placeholder="Number of family members" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="education">Education</label>
        <input type="text" id="education" name="education" placeholder="Your highest education" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="profession">Profession</label>
        <input type="text" id="profession" name="profession" placeholder="Your profession" required />
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label>Languages Known</label>
        <div class="checkbox-group">
          <div class="checkbox-option">
            <input type="checkbox" id="english" name="languages[]" value="English" />
            <label for="english">English</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="hindi" name="languages[]" value="Hindi" />
            <label for="hindi">Hindi</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="bengali" name="languages[]" value="Bengali" />
            <label for="bengali">Bengali</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="tamil" name="languages[]" value="Tamil" />
            <label for="tamil">Tamil</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="telugu" name="languages[]" value="Telugu" />
            <label for="telugu">Telugu</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="otherLang" name="languages[]" value="Other" />
            <label for="otherLang">Other</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label>Hobbies</label>
        <div class="checkbox-group">
          <div class="checkbox-option">
            <input type="checkbox" id="reading" name="hobbies[]" value="Reading" />
            <label for="reading">Reading</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="music" name="hobbies[]" value="Music" />
            <label for="music">Music</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="traveling" name="hobbies[]" value="Traveling" />
            <label for="traveling">Traveling</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="sports" name="hobbies[]" value="Sports" />
            <label for="sports">Sports</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="cooking" name="hobbies[]" value="Cooking" />
            <label for="cooking">Cooking</label>
          </div>
          <div class="checkbox-option">
            <input type="checkbox" id="photography" name="hobbies[]" value="Photography" />
            <label for="photography">Photography</label>
          </div>
        </div>
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="nationality">Nationality</label>
        <input type="text" id="nationality" name="nationality" placeholder="Your nationality" required />
        <div class="error"></div>
      </div>

      <div class="input-control">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Your phone number" required />
        <div class="error"></div>
      </div>

      <div class="input-control full-width">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3" placeholder="Your full address" required></textarea>
        <div class="error"></div>
      </div>

      <button type="submit" name="submit" class="btn btn-primary">
        <i class="fas fa-file-pdf"></i> Generate Biodata 
      </button>
    </form>
  </div>
  <!-- <script src="practice.js"></script> -->
</body>
</html>
