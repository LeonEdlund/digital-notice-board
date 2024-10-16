<?php
$page = (isset($_GET['page'])) ? trim($_GET['page']) : "alla";
$post = (isset($_GET['post'])) ? trim($_GET['post']) : 0;
?>

<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.conditional.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker/dist/css/datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker/dist/js/datepicker.min.js"></script>
  <link rel="stylesheet" href="styles/reset.css">
  <link rel="stylesheet" href="styles/style.css">
  <script src="js/modal.js"></script>
  <script src="js/form.js"></script>
  <title>Anslagstavla</title>
</head>

<body>
  <header>
    <nav>
      <h1>Anslagstavla</h1>
      <div class="pico">
        <button onclick="toggleModal(event, 'upload-modal')">Ladda upp</button>
      </div>
    </nav>
  </header>

  <main>
    <!-- MENU -->
    <aside>
      <nav>
        <ul>
          <li>
            <a href="?page=alla" <?= ($page === "alla") ? "id='active'" : "" ?>>
              Alla annonser
            </a>
          </li>
          <li>
            <a href="?page=evenemang" <?= ($page === "evenemang") ? "id='active'" : "" ?>>
              Evenemang
            </a>
          </li>
          <li>
            <a href="?page=aktiviteter" <?= ($page === "aktiviteter") ? "id='active'" : "" ?>>
              Aktiviteter
            </a>
          </li>
          <li>
            <a href="?page=utbildning" <?= ($page === "utbildning") ? "id='active'" : "" ?>>
              Utbildning och Kurser
            </a>
          </li>
          <li>
            <a href="?page=kop-salj" <?= ($page === "kop-salj") ? "id='active'" : "" ?>>
              Köp/Sälj/Byt
            </a>
          </li>
          <li>
            <a href="?page=efterlyst" <?= ($page === "efterlyst") ? "id='active'" : "" ?>>
              Efterlyst/Borttappat
            </a>
          </li>
          <li>
            <a href="?page=samhallsinformation" <?= ($page === "samhallsinformation") ? "id='active'" : "" ?>>
              Samhällsinformation
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- ALL POSTS -->
    <section>
      <h2>Alla Annonser</h2>
      <div id="post-grid">
        <div data-id="<?= $page ?>" class="pico" onclick="toggleModal(event, 'post-modal', 1)">
          <article>
            <header>
              <strong>Borttappad hund</strong>
            </header>
            <div class="img-container">
              <img src="images/image.png" alt="">
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore!</p>
            <footer>20-12-2024</footer>
          </article>
        </div>
    </section>

  </main>

  <!-- MODALS -->
  <div class="pico">
    <!-- POST MODALS -->
    <dialog id="post-modal">
      <article>
        <button aria-label="Close" rel="prev" id="close" onclick="toggleModal(event, 'post-modal')"></button>
        <div>
          <hgroup>
            <h2>Title</h2>
            <h3>14-12-2024</h3>
          </hgroup>
          <p></p>
        </div>
      </article>
    </dialog>

    <!-- UPLOAD MODALS -->
    <dialog id="upload-modal" open>
      <article>
        <button aria-label=" Close" rel="prev" id="close" onclick="toggleModal(event, 'upload-modal')"></button>
        <div id="upload-grid">
          <div id="qr">
            <p>Ladda upp från telefonen</p>
            <div id="qr-placeholder"></div>
            <p>bla bla bla</p>
          </div>
          <div id="line"></div>
          <div id="form-wrapper">
            <h3>Ladda upp annons</h3>
            <form action="">
              <input type="text" placeholder="Titel">
              <select name="category" id="category" aria-label="Välj kategori" required>
                <option selected disabled value="">
                  Kategori
                </option>
                <option value="event">Evenemang</option>
                <option value="activity">Aktivitet</option>
                <option value="buy">Köp/sälj/byt</option>
                <option value="info">Samhällsinformation</option>
              </select>

              <div id="date-section">
                <div id="date-fields">
                  <input type="text" id="datepicker" placeholder="Välj datum" />
                  <img src="images/info.svg" alt="" height="40">
                </div>

                <fieldset>
                  <label>
                    <input type="checkbox" id="checkbox" name="no-date" />
                    Annonsen sker inte på något specifikt datum
                  </label>
                </fieldset>

              </div>

              <textarea name="text" id="text" placeholder="text" rows="10"></textarea>

              <input type="submit" value="LADDA UPP">
            </form>
          </div>
        </div>
      </article>
    </dialog>
  </div>
</body>

</html>