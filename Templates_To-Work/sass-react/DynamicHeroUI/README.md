 

## 🎯 1. Project Name Ideas

* **FlexiLanding**
* **DynamicHeroUI**
* **ContentSwitcher**
* **GridPromoKit**
* **ModuPage**

Pick one that speaks to the idea of a flexible, modular landing/header you can repurpose for anime, cars, products, etc.

---

## 📂 2. Core Element Class/ID Names

```html
<!-- Layout Wrappers -->
<div id="app-wrapper">         <!-- overall page container -->
  <header class="header">      <!-- top header/search area -->
  <main class="hero-section">  <!-- hero/landing area -->
  <section class="promo-section"> <!-- bottom promo area -->
  <aside class="sidebar-nav">  <!-- left sidebar -->
  <footer class="footer">      <!-- optional footer -->
</div>
```

### 🧱  Structural Elements

| Role                       | Suggested Class / ID |
| -------------------------- | -------------------- |
| App root                   | `#app-wrapper`       |
| Header bar                 | `.header`            |
| Navigation list            | `.nav-list`          |
| Nav item                   | `.nav-item`          |
| Search input wrapper       | `.search-bar`        |
| Search input field         | `#search-input`      |
| Filter button              | `.filter-btn`        |
| Hero / slogan container    | `.hero-section`      |
| Slogan text                | `.hero-slogan`       |
| Hero image wrapper         | `.hero-image`        |
| Sidebar container          | `.sidebar-nav`       |
| Sidebar profile avatar     | `.sidebar-profile`   |
| Sidebar menu item          | `.sidebar-item`      |
| New arrivals box           | `.new-arrivals-box`  |
| New arrivals “Get Now” btn | `.btn--new-arrivals` |
| Promo banner container     | `.promo-section`     |
| Promo text                 | `.promo-text`        |
| Promo button               | `.btn--shop-now`     |
| Promo character image      | `.promo-character`   |
| Global grid wrapper        | `.grid-container`    |
| Card / tile                | `.card`              |
| Button base                | `.btn`               |

---

## ⚙️ 3. Tech Stack Recommendation

| Option                                              | Pros                                                                                                                         | Cons                                           |
| --------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------- |
| **Plain HTML + CSS/Sass**                           | – Super lightweight<br>– No build step                                                                                       | – Harder to make dynamic content swaps         |
| **Sass only (with partials)**                       | – Organized stylesheets<br>– Variables, mixins                                                                               | – Still static markup                          |
| **React + Sass**                                    | – Component-driven (reusable Hero, Sidebar, Card…)<br>– Easy prop-based content swapping<br>– Scales to pages beyond landing | – Requires build setup (Node.js, Webpack/Vite) |
| **Static Site Generator**<br>(e.g. Eleventy, Astro) | – Markdown/data-driven pages<br>– Fast builds                                                                                | – Learning curve                               |

Because you’ll often swap out images/text (anime → cars → products), I **recommend React + Sass**:

1. **Components**:

   ```jsx
   <Hero 
     slogan="Explore the Ultimate Lineup" 
     imageSrc="/images/my-character.png" 
   />
   <PromoBanner 
     text="40% OFF ON FIGURE" 
     btnText="Shop Now" 
   />
   ```
2. **Props & Data**: feed each component JSON or a config file to swap content without touching markup.
3. **Sass Modules**: scope styles to each component (`Hero.module.scss`, etc.).
 