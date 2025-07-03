<?php
  require_once __DIR__ . '/../php/bootstrap.php';
  require_once __DIR__ . '/../php/session.php';
?>
<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
    <link rel="stylesheet" href="./../assets/tailwind.css">
    <link rel="icon" href="./../assets/ecogroup-icon.png">
    <title>ecogroup-app</title>
    <style lang="scss" scoped></style>
  </head>
  <body>
    <div class="flex flex-col h-screen justify-between font-Roboto text-gray-200">
      <?php if(isset($_SESSION['user_id'])) { ?>
        <header class="sticky top-0 z-20 shadow-md bg-site-primary bg-opacity-80 backdrop-blur-lg border-b-green-700 border-b rounded-b-lg mx-1">
          <nav class="container flex items-center w-full py-2 justify-between">
            <div class="flex items-center gap-2 font-Inter mx-auto">
              <img src="./assets/ecogroup-icon.png" class="h-12 w-12" alt="ecogroup logo">
              <a class="self-center text-2xl font-semibold whitespace-nowrap" href="/api-logout.php">Eco Group</a>
            </div>
            <a class="relative shadow-md justify-end border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary" href="/api/api-logout.php" ><i class="fa-solid fa-right-from-bracket"></i>Log out</a>
          </nav>
        </header>
        <?php if($_SESSION['user_type'] == "company") { ?>
          <nav class="rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1 pt-5 pb-3">
            <div class="flex justify-center gap-3 md:gap-10 text-center w-full mx-auto">
              <a href="QuestionnairesView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                <i class="fa-solid fa-clipboard-check"></i>
                <span class="self-center text-xl whitespace-nowrap">Questionari svolti</span>
              </a>
              <a href="QuestionnairesFillView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                <i class="fa-solid fa-clipboard-question"></i>
                <span class="self-center text-xl whitespace-nowrap">Nuovo questionario</span>
              </a>
            </div>
          </nav>
        <?php } elseif($_SESSION['user_type'] == "moderator") { ?>
          <nav class=" rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1 pt-5 pb-3 z-10">
            <ul class="flex justify-center gap-3 md:gap-10 text-center w-full mx-auto">
              <li>
                <a href="AdminLoggedView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                  <i class="fa-solid fa-chart-pie"></i>
                  <span class="self-center text-xl whitespace-nowrap">Statistiche</span>
                </a>
              </li>
              <li>
                <a href="AdminOperationsView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                  <i class="fa-solid fa-hammer"></i>
                  <span class="self-center text-xl whitespace-nowrap">Admin</span>
                </a>
              </li>
              <li>
                <a href="AdminQuestionsView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                  <i class="fa-solid fa-clipboard-question"></i>
                  <span class="self-center text-xl whitespace-nowrap">Domande</span>
                </a>
              </li>
              <li>
                <a href="AdminSurveysView.php?user_id=<?=$_SESSION['user_id']?>&user_type=<?=$_SESSION['user_type']?>" class="flex items-center mb-4 space-x-3 shadow-md rtl:space-x-reverse bg-black bg-opacity-20 rounded-lg p-2 px-5 hover:bg-opacity-30 border border-site-primary">
                  <i class="fa-solid fa-book"></i>
                  <span class="self-center text-xl whitespace-nowrap">Questionari</span>
                </a>
              </li>
            </ul>
          </nav>
        <?php
            }
          } else {
        ?>
        <header class="sticky top-0 z-20 shadow-md bg-site-primary bg-opacity-80 backdrop-blur-lg border-b-green-700 border-b rounded-b-lg mx-1">
          <nav class="container flex items-center w-full py-2 justify-between">
            <div class="flex items-center gap-2 font-Inter mx-auto">
              <img src="./assets/ecogroup-icon.png" class="h-12 w-12" alt="ecogroup logo">
              <a class="self-center text-2xl font-semibold whitespace-nowrap" href="HomeView.php">Guida</a>
            </div>
            <a class="border-green-800 border rounded-xl p-2 hover:bg-green-700 cursor-pointer bg-site-primary shadow-md" href="LoginView.php">Log in</a>
          </nav>
        </header>
        <footer class="rounded-t-lg bg-opacity-70 shadow-md bg-site-primary border-t border-green-600 mx-1 z-50 h-fit">
          <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
              <div class="sm:flex sm:items-center sm:justify-between">
                <a href="#"  class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="./assets/ecogroup-icon.png" class="h-8" alt="Eco Group Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap">Eco Group</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium sm:mb-0 space-x-6">
                  <li>
                      <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                  </li>
                  <li>
                      <a href="#" class="hover:underline">Contact</a>
                  </li>
              </ul>
              </div>
          </div>
        </footer>
      <?php } ?>
    </div>
  </body>
</html>
