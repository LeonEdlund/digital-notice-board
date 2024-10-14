<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="color-scheme" content="light" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.conditional.min.css">
  <link rel="stylesheet" href="styles/reset.css">
  <link rel="stylesheet" href="styles/style.css">
  <script src="js/modal.js"></script>
  <title>Anslagstavla</title>
</head>

<body>
  <header>
    <nav>
      <h1>Anslagstavla</h1>
      <div class="pico">
        <button>Ladda upp</button>
      </div>
    </nav>
  </header>

  <main>
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

    <section>
      <h2>Alla Annonser</h2>
      <div id="post-grid">
        <div data-id="<?= $page ?>" class="pico post-modal" onclick="toggleModal(event, 'post-modal', 1)">
          <article>
            <header>
              <strong>Borttappad hund</strong>
            </header>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab perspiciatis odit repellat, ut nesciunt deserunt atque animi dolores error placeat alias molestiae praesentium, soluta recusandae ipsa aliquam minima natus labore!</p>
            <footer>20-12-2024</footer>
          </article>
        </div>
      </div>

    </section>

  </main>

  <div class="pico">
    <dialog id="post-modal">
      <article>
        <button aria-label="Close" rel="prev" id="close" onclick="toggleModal(event, 'post-modal')"></button>
        </header>
        <div>
          <hgroup>
            <h2>Title</h2>
            <h3>14-12-2024</h3>
          </hgroup>
          <p></p>
        </div>
      </article>
    </dialog>

    <dialog close>
      <article>
        <button aria-label=" Close" rel="prev" id="close"></button>
        </header>
        <div>
          <div id="qr">
            <div id="qr-placeholder"></div>
            <p>Ladda upp från telefonen</p>
          </div>
          <div id="form-wrapper">
            <form action="">
              <input type="text" placeholder="title">
              <textarea name="" id="" placeholder="text" rows="10"></textarea>
            </form>
          </div>
        </div>
      </article>
    </dialog>
  </div>
</body>

</html>