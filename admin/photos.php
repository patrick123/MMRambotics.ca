<?php

  /*
   * @author: Andrew Horsman | MMRambotics.ca
   * @description: Administration can edit and add photo albums and entries.
   */

  session_start();
  require_once("quick_admin_lib.php");
  require_once("../lib/photo_gallery_helper.php");

  QuickAdmin::redirectIfNotLoggedIn();

  function displayAlbumOptions() {
    $albums  = PhotoGalleryHelper::getAlbumsRaw();
    $default = PhotoGalleryHelper::getDefaultAlbumPath();

    ?>
      <table border="1">
        <tr>
          <th>Album</th>
          <th>Administer</th>
          <th>Default</th>
          <th>Delete</th>
        </tr>
      </table>
    <?php

    foreach ($albums as $albumName => $albumPath) {
      ?>
        <tr>
          <td><?php echo $albumName; ?></td>
          <td><a href="photos.php?administer=<?php echo $albumName; ?>" title="Administer">Administer</a
          <td><?php echo (($default == $albumPath) ? 'Is Default' : '<a href="photos.php?makedefault=' . $albumName . '">Make Default</a>'); ?></td>
          <td><a href="photos.php?delete=<?php echo $albumName; ?>">Delete</a></td>
        </tr>
      <?php
    }

    ?>
      </table>

      <hr />
  
      <a href="photos.php?addplaylist=add" title="Add Playlist">Add a Playlist</a>
    <?php
  }

  function displayAlbumAdministration() {
    $path   = PhotoGalleryHelper::getAlbumPath($_GET["administer"]);
    $photos = PhotoGalleryHelper::getPhotosFromPlaylistPath($path);

    ?>
      <table border="1">
        <tr>
          <th>Title</th>
          <th>Image URL</th>
          <th>Description</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
    <?php
      
      foreach ($photos as $photoId => $photo) {
        ?>
          <tr>
            <td><?php echo $photo["title"]; ?></td>
            <td><a href="<?php echo $photo["url"]; ?>"><?php echo $photo["url"]; ?></a></td>
            <td><?php echo $photo["description"]; ?></td>
            <td><a href="photos.php?editphoto=<?php echo $photoId; ?>&album=<?php echo $_GET["administer"]; ?>">Edit</a></td>
            <td><a href="photos.php?deletephoto=<?php echo $photoId; ?>&album=<?php echo $_GET["administer"]; ?>">Delete</a></td>
          </tr>
        <?php
      }

    ?>
      </table>
      <hr />
      <a href="photos.php?addphoto=add&playlist=<?php echo $_GET["administer"]; ?>" title="Add Photo">Add a Photo</a>
    <?php
  }

  function makeDefaultAlbum() {

  }

  function deleteAlbum() {

  }

  function displayAddAlbumForm() {

  }

  if (isset($_GET["administer"]))
    displayAlbumAdministration();
  else if (isset($_GET["makedefault"]))
    makeDefaultAlbum();
  else if (isset($_GET["delete"]))
    deleteAlbum();
  else if (isset($_GET["addplaylist"]))
    displayAddAlbumForm();
  else
    displayAlbumOptions();

?>

