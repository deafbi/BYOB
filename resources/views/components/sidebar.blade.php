<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<script src="https://kit.fontawesome.com/4ccfd0940c.js" crossorigin="anonymous"></script>
<script
      type="module"
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
    ></script>
    <script
      nomodule
      src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
    ></script>
    <div class="container">
      <div class="logo">
        <i class="fa-solid fa-globe fa-3x"></i>
        <span style="font-size: 25px; font-weight: 800;width: 100%; text-align: center; margin-left: -80px;">BYOB</span>
      </div>
      <ul class="link-items">
        <li class="link-item active">
          <a href="/admin/dashboard" class="link">
            <ion-icon name="home-outline"></ion-icon>
            <span style="--i: 1">Home</span>
          </a>
        </li>
        <li class="link-item">
          <a href="/" class="link">
            <ion-icon name="eye-outline"></ion-icon>
            <span style="--i: 2">preview</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link"
            ><ion-icon name="document-outline"></ion-icon>
            <span style="--i: 3">config</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="bug-outline"></ion-icon>
            <span style="--i: 4">logs</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="server-outline"></ion-icon
            ><span style="--i: 5">server stats</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="help-circle-outline"></ion-icon>
            <span style="--i: 7">help</span>
          </a>
        </li>
        <li class="link-item">
          <a href="#" class="link">
            <ion-icon name="settings-outline"></ion-icon>
            <span style="--i: 7">Settings</span>
          </a>
        </li>
      </ul>
    </div>
    <script>
        const container = document.querySelector(".container");
const linkItems = document.querySelectorAll(".link-item");
const darkMode = document.querySelector(".dark-mode");
const logo = document.querySelector(".logo svg");

//Container Hover
container.addEventListener("mouseenter", () => {
  container.classList.add("active");
});

//Container Hover Leave
container.addEventListener("mouseleave", () => {
  container.classList.remove("active");
});

//Link-items Clicked
for (let i = 0; i < linkItems.length; i++) {
  if (!linkItems[i].classList.contains("dark-mode")) {
    linkItems[i].addEventListener("click", (e) => {
      linkItems.forEach((linkItem) => {
        linkItem.classList.remove("active");
      });
      linkItems[i].classList.add("active");
    });
  }
}

// Dark Mode Functionality
darkMode.addEventListener("click", function () {
  if (document.body.classList.contains("dark-mode")) {
    darkMode.querySelector("span").textContent = "dark mode";
    darkMode.querySelector("ion-icon").setAttribute("name", "moon-outline");

    logo.style.fill = "#363b46";
  } else {
    darkMode.querySelector("span").textContent = "light mode";
    darkMode.querySelector("ion-icon").setAttribute("name", "sunny-outline");
    logo.style.fill = "#fff";
  }
  document.body.classList.toggle("dark-mode");
});
    </script>