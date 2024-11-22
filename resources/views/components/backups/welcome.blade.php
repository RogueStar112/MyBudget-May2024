<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MyBudget</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="app.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />

    <link href="{{ asset('css/mybudget_home_2023.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>

  <body class="max-w-5xl mx-auto font-montserrat">
    <header class="flex py-6 justify-between items-center flex-col md:flex-row">
      <img src="https://my-budget-may2024.vercel.app/images/mybudget/mybudgetlogo30092023_v2.svg" class="logo-bgcolor-forest max-h-16" alt="">
      <nav class="flex gap-4 font-extrabold text-green-600 text-center">
        <a href="/..">Home</a>
        <a href="/budgeting-app">App</a>
        <!-- <a href="">Accessibility</a> -->
        <a href="/register">Register</a>
  
        <button id="dark-mode-btn" class="light">
          <img src="./assets/icons/sun.png" alt="">
        </button>
      </nav>
    </header>
  
    <main class="">
      <!-- <div id="image-container" class="w-full h-48">
        <img
          class="object-cover object-left w-full max-h-48"
          src="assets/keyboardtyping.jpg"
          alt=""
        />
      </div> -->
  
      <section id="hero-container" class="flex flex-col md:flex-row text-center md:text-left /bg-gradient-to-r /from-transparent /from-20% /to-90% /to-green-100">
      
        <div id="main-descriptor" class="flex flex-col md:flex-row items-center w-full md:w-7/12 mx-auto md:mx-0 md:h-auto">
          <article id="hero-description" class="mx-6">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-green-600">
              Flexible budgeting at your fingertips
            </h1>
            <p class="">
              Achieve <span class="text-blue-500">savings goals</span> with
              ease, with
              <span class="text-red-500">customizable categories</span> that
              tailor to your needs. With an award-winning<span class="text-orange-500">
                tracking system</span>, we'll ensure that your money doesn't go off the rails.
            </p>
          </article>
        </div>
  
        <div class="none md:w-5/12" id="image-container">
          <div class="relative h-full hidden md:block">
            <div class="absolute top-0 right-0 w-1/4 h-1/4 gold-gradient"></div>
            <img src="https://my-budget-may2024.vercel.app/images/mybudget/budget.png" alt="" class="">
          </div>
        </div>
      </section>
  
      <hr class="mt-3 md:border-4 md:border-b-orange-500">
  
      <section class="w-full text-center mt-6">
        <h2 class="text-2xl md:text-5xl font-extrabold text-green-600 md:block">
          What MyBudget offers
        </h2>
  
        <section id="features-container" class="justify-between /[&amp;>section]:flex /[&amp;>section]:flex-col mt-6 gap-24">
          <div class="first-row flex justify-around flex-col md:flex-row gap-24 md:gap-0">
            <section class="feature-container mx-auto md:mx-0">
              <div class="">
                <img src="https://my-budget-may2024.vercel.app/images/mybudget/icons/folder-management.png" alt="" class="logo-bgcolor-forest">
                <h3 class="font-extrabold text-lg">Customizable Categories</h3>
              </div>
              <!-- <img
              src="https://dummyimage.com/300x200/000/fff&text=Deep+Customization"
              alt=""
            /> -->
  
              <p class="">
                Know exactly where your money is going, through a tailored
                category system.
              </p>
            </section>
  
            <section class="feature-container mx-auto md:mx-0">
              <img class="logo-bgcolor-forest" src="https://my-budget-may2024.vercel.app/images/mybudget/icons/bar-chart.png" alt="">
              <h3 class="font-extrabold text-lg">Spending Patterns</h3>
              <!-- <img
              src="https://dummyimage.com/300x200/000/fff&text=Trending+Tools"
              alt=""
            /> -->
              <p>
                Understand how your money fluctuates, giving you a chance to
                prepare.
              </p>
            </section>
  
            <section class="feature-container mx-auto md:mx-0">
              <img class="logo-bgcolor-forest" src="https://my-budget-may2024.vercel.app/images/mybudget/icons/encryption.png" alt="">
  
              <h3 class="font-extrabold text-lg">
                Powerful Database Encryption
              </h3>
  
              <p class="text-sm text-center">
                Your lifestyle and money is no business to others but yourself.
              </p>
            </section>
          </div>
  
          <div class="last-row-grid flex justify-around flex-col md:flex-row gap-24 mt-16">
            <section class="feature-container mx-auto md:mx-0">
              <img class="logo-bgcolor-forest" src="https://my-budget-may2024.vercel.app/images/mybudget/icons/hide.png" alt="">
  
              <h3 class="font-extrabold text-lg">Privacy Settings</h3>
  
              <p class="text-sm text-center">
                Keep spending balances and activity as discreet or as open as
                needed.
              </p>
            </section>
  
            <section class="feature-container mx-auto md:mx-0">
              <img class="logo-bgcolor-forest" src="https://my-budget-may2024.vercel.app/images/mybudget/icons/accessibility.png" alt="">
  
              <h3 class="font-extrabold text-lg">Top-Class Accessibility</h3>
  
              <p class="text-sm text-center">
                Custom interface themes, easier-to-read fonts, you name it.
              </p>
            </section>
          </div>
        </section>
      </section>
  
      <section>
        <div class="text-center"></div>
      </section>
    </main>
  
    <hr class="mt-3 border-4 border-b-orange-500">
  
    <footer class="h-28 text-center mt-6 text-2xl">
      © MyLifeline Productions 2024
    </footer>
  </body>
</html>
