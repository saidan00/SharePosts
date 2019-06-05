<?php require_once APPROOT . "/views/inc/header.php"; ?>
      <a href="<?php echo URLROOT; ?>/posts"><i class="fa fa-backward"></i> Back</a>
      <?php flash("post_message"); ?>
      <div class="container mt-3">
        <div class="card">
          <div class="card-header">
            <h4 class="font-weight-bold"><?php echo $data["post"]->title; ?></h4>
            <small class="bg-light"><i>Posted by <b><?php echo $data["user"]->name; ?></b> on <?php echo $data["post"]->postCreated; ?></i></small>
          </div>
          <div class="card-body">
            <?php echo $data["post"]->body; ?>
          </div>

          <?php if ($data["post"]->user_id == $_SESSION["user_id"]) : ?>
            <div class="card-footer">
              <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data["post"]->id; ?>" class="btn btn-dark">Edit</a>
              <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data["post"]->id; ?>" method="post" class="pull-right">
                <input type="submit" value="Delete" class="btn btn-danger">
              </form>
            </div>
          <?php endif; ?>

        </div>
      </div>


<?php require_once APPROOT . "/views/inc/footer.php"; ?>
