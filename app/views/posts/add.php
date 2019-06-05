<?php require_once APPROOT . "/views/inc/header.php"; ?>
      <a href="<?php echo URLROOT; ?>/posts"><i class="fa fa-backward"></i> Back</a>
      <div class="card card-body mt-3">
        <h2>Add Post</h2>
        <p>Create a post with this form</p>
        <form action="<?php echo URLROOT; ?>/posts/add" method="post">
          <div class="form-group">
            <label for="title">Title <span class="text-danger font-weight-bold">*</span></label>
            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data["title_err"])) ? "is-invalid" : ""; ?>" value="<?php echo $data["title"] ?>">
            <span class="invalid-feedback"><?php echo $data["title_err"]; ?></span>
          </div>
          <div class="form-group">
            <label for="body">Body <span class="text-danger font-weight-bold">*</span></label>
            <textarea name="body" class="form-control form-control-lg<?php echo (!empty($data["body_err"])) ? " is-invalid" : ""; ?>"><?php echo $data["body"] ?></textarea>
            <span class="invalid-feedback"><?php echo $data["body_err"]; ?></span>
          </div>

          <div class="row">
            <div class="col">
              <input type="submit" value="Add post" class="btn btn-success">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php require_once APPROOT . "/views/inc/footer.php"; ?>
