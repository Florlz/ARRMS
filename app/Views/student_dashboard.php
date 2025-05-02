    <!DOCTYPE html>
    <html>
    <head>
        <title>Student Dashboard</title>
        <link rel="stylesheet" href="<?= base_url('css/student_css.css') ?>">
    </head>
    <body>

    <div class="container">
        <div class="sidebar">
            <div>
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User">
                <h3>&lt;Name&gt;</h3>
                <p>Welcome &lt;Name&gt;</p>
                <div class="nav">
                    <div class="nav-item active"><i>📄</i>Profile</div>
                    <div class="nav-item"><i>📤</i>Request Documents</div>
                    <div class="nav-item"><i>📋</i>View Request Status</div>
                </div>
            </div>
            <form method="post" action="/logout">
                <button class="logout-btn">Log out</button>
            </form>
        </div>

        <div class="main-content">
            <div class="card">
                <h2>Profile Information</h2>
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label>ID Number</label>
                            <input type="text" name="id_number">
                        </div>
                        <div class="form-group">
                            <label>Type of Admission</label>
                            <input type="text" name="admission_type">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name">
                        </div>
                        <div class="form-group">
                            <label>College</label>
                            <input type="text" name="college">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Birthdate</label>
                            <input type="date" name="birthdate">
                        </div>
                        <div class="form-group">
                            <label>Birthplace</label>
                            <input type="text" name="birthplace">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email">
                        </div>
                    </div>

                    <div class="button-row">
                        <button type="reset" class="btn btn-discard">Discard Changes</button>
                        <button type="submit" class="btn btn-save">Edit Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </body>
    </html>