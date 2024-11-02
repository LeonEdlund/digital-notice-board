<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.conditional.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker/dist/css/datepicker.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">

  <link rel="stylesheet" href="styles/reset.css">
  <link rel="stylesheet" href="styles/style.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">
  <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker/dist/js/datepicker.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/locales/sv.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>

  <script src="js/form.js"></script>
  <script src="js/modal.js"></script>
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
      <nav id="menu-list">
        <ul>
          <?php
          foreach ($menuItems as $key => $value) {
            $active = ($page === $key) ? "id='active'" : "";
            echo "<li><a href='?page=$key' $active>$value</a></li>";
          }
          ?>
        </ul>
      </nav>
      <div id="qr">
        <h4 id="upload-from-title">Ladda upp från telefonen</h4>
        <img src="images/qr.svg" id="qr-placeholder" />
      </div>
    </aside>

    <!-- ALL POSTS -->
    <section id="posts-section">

      <div id="category-name-menu" class="pico">
        <?php if ($page !== "kop-salj" && $page !== "efterlyst") : ?>
          <?=
          isset($_GET['date']) ? "<h2>" . htmlspecialchars(date('d/m-y', strtotime($_GET['date']))) . "</h2>" : ""
          ?>
          <form method="GET" id="date-search-form">
            <input type="hidden" name="page" value="<?= htmlspecialchars($page) ?>">
            <div id="calendar-icon">
              <img src="images/search-icon.svg" height="50px" alt="error">
            </div>
            <input type="text" id="datepicker-2" name="date" />
          </form>
        <?php endif ?>
      </div>

      <div id="post-grid">
        <?php if (empty($posts)) : ?>
          <p>Inga annonser... :/</p>
        <?php endif ?>

        <?php foreach ($posts as $post) : ?>
          <div class="pico" onclick="toggleModal(event, 'modal-<?= $post->id ?>')">
            <article>
              <div class="img-container">
                <img src="<?= htmlspecialchars($post->img) ?>" alt="">
              </div>
              <h3 class="card-title"><strong><?= ucfirst(htmlspecialchars($post->title)) ?></strong></h3>
              <p class="text-content"><?= nl2br(htmlspecialchars($post->body)) ?></p>
              <footer>
                <?php
                if (!empty($post->dates) && $post->dates[0]->event_date) {
                  if (count($post->dates) === 1) {
                    echo "<p>{$post->dates[0]->event_date}</p>";
                  } else {
                    echo "<p>{$post->dates[0]->event_date}" .  " (" . count($post->dates) . "+)</p>";
                  }
                } else {
                  echo "<p><span style='opacity: 0;'>|</span></p>";
                }
                ?>
              </footer>
            </article>
          </div>
        <?php endforeach ?>
    </section>

  </main>

  <!-- MODALS -->
  <div class="pico">
    <!-- POST MODALS -->
    <?php foreach ($posts as $post) : ?>
      <dialog class="post-modal" id="modal-<?= $post->id ?>">
        <article>
          <button aria-label="Close" rel="prev" id="close" onclick="toggleModal(event, 'modal-<?= $post->id ?>')"></button>
          <div id="modal-wrapper">

            <img src="<?= htmlspecialchars($post->img) ?>" alt="">


            <div class="post-content">
              <hgroup>
                <h2><?= htmlspecialchars(ucfirst($post->title)) ?></h2>
                <h3><?= htmlspecialchars(date('d/m-y', strtotime($post->created_at))) ?></h3>
              </hgroup>
              <p><?= nl2br(htmlspecialchars($post->body)) ?></p>
            </div>

            <?php if ($post->dates) : ?>
              <hr>
              <h4>Datum</h4>
              <ul class="dates-list">
                <?php foreach ($post->dates as $date) : ?>
                  <li class="date-card">
                    <p class="date-red-bar"><?= $date->month ?></p>
                    <p class="date-day"><?= $date->day ?></p>
                  </li>
                <?php endforeach  ?>
              </ul>
            <?php endif  ?>
        </article>
      </dialog>
    <?php endforeach  ?>

    <!-- UPLOAD MODAL -->
    <dialog id="upload-modal" <?= ($postUploaded) ? "close" : "" ?> <?= (!empty($errors)) ? "open" : "" ?>>
      <article>
        <button aria-label=" Close" rel="prev" id="close" onclick="toggleModal(event, 'upload-modal')"></button>
        <!-- <div id="upload-grid"> -->
        <!-- <div id="qr">
            <h4>Ladda upp från telefonen</h4>
            <img src="images/qr.png" id="qr-placeholder" />
            <p>Scanna qr koden för att ladda upp en annons via mobilen! Då är det även möjligt att ladda upp en bild till din annons 🌆 📸</p>
          </div>

          <div id="line"></div> -->

        <div id="form-wrapper">
          <form action="" method="POST" id="upload-form">
            <h3>Ladda upp annons</h3>
            <input name="title" type="text" placeholder="Titel">

            <select name="category" id="category" aria-label="Välj kategori">
              <option selected disabled value="">Kategori</option>
              <option value="event" data-date="date">Evenemang</option>
              <option value="activity" data-date="date">Aktivitet</option>
              <option value="education" data-date="date">Utbildning eller kurs</option>
              <option value="buy" data-date="no-date">Köp/sälj/byt</option>
              <option value="lost" data-date="no-date">Efterlyst/Borttappat</option>
              <option value="info" data-date="no-date">Samhällsinformation</option>
              <option value="else" data-date="no-date">Övrigt</option>
            </select>


            <div id="date-section">
              <div id="date-fields">
                <input type="text" id="datepicker" name="event_date" placeholder="Välj ett eller flera datum" />
                <div id="icon-wrapper">
                  <img src="images/info.svg" alt="" height="40" id="info-icon">
                  <div id="info-box">
                    <p>Ange datum för när det du annonserar om inträffar. Om det gäller flera dagar kan du lägga till fler datum.</p>
                    <p>Annonsen raderas automatiskt dagen efter det sista angivna datumet.</p>
                  </div>
                </div>
              </div>

              <fieldset>
                <label>
                  <input type="checkbox" id="checkbox" role="switch" name="no-date" />
                  Annonsen sker inte på något specifikt datum
                </label>
              </fieldset>
            </div>

            <textarea name="description" id="description" placeholder="Beskrivning" rows="6"></textarea>

            <div class="simple-keyboard"></div>

            <div id="button-wrapper">
              <input type="submit" id="submit-btn" value="LADDA UPP">
            </div>
          </form>
        </div>
        <!-- </div> -->
      </article>
    </dialog>


    <!-- FEEDBACK MODAL -->
    <?php if ($postUploaded) : ?>
      <dialog id="feedback-modal" <?= $postUploaded ? "open" : "" ?>>
        <article>
          <button aria-label=" Close" rel="prev" id="close" onclick="location.href='?page=<?= $page ?>'"></button>
          <h3>Annons uppladdad</h3>
        </article>
      </dialog>
      <?php $postUploaded = false; ?>
    <?php endif ?>
  </div>

</body>

</html>