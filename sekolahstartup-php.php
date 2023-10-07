<?php
// index.php
require_once('./vendor/autoload.php');
use Postmark\PostmarkClient;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
   // Connect to SQLite database
   $database = new PDO('sqlite:data.db');
   $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get email from POST data and convert it to lowercase
$email = strtolower($_POST['email']);

   // Create table if not exists
   $database->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, email TEXT NOT NULL UNIQUE)");
// Add a new column 'paid_member' to the 'users' table
$database->exec("ALTER TABLE users ADD COLUMN paid_member INTEGER DEFAULT 0");

   // Check if email already exists in users table
   $stmt = $database->prepare("SELECT * FROM users WHERE email = :email");
   $stmt->bindParam(':email', $email);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
       // Email already exists in database, don't insert again
   } else {
       // Insert email into users table
       $stmt = $database->prepare("INSERT OR IGNORE INTO users (email) VALUES (:email)");
       $stmt->bindParam(':email', $email);
       $stmt->execute();
       
   }
    // Create a Postmark client
    $client = new Postmark\PostmarkClient("23eebfa4-8ab8-4b4d-97b8-8ef0351d7708");

    // Send an email
    $sendResult = $client->sendEmail(
        "cs@sekolahstartup.com",
        $email,
        "Welcome to SekolahStartup!",
        "Thank you for registering!"
    );

    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>SekolahStartup</title>
</head>

<body>
    <!-- Homepage - Navigation - Start      -->
    <section class="w-full px-8 text-gray-700 bg-white" {!! $attributes ?? '' !!}>
        <div class="container flex flex-col flex-wrap items-center justify-between py-5 mx-auto md:flex-row max-w-7xl">
            <div class="relative flex flex-col md:flex-row">
                <a href="#_"
                    class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                    <span class="mx-auto text-xl font-black leading-none text-gray-900 select-none">SekolahStartup<span
                            class="text-indigo-600" data-primary="indigo-600">.</span></span>
                </a>
                <nav
                    class="flex flex-wrap items-center mb-5 text-base md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-200">
                    <a href="/" class="mr-5 font-medium leading-6 text-gray-600 hover:text-gray-900">Home</a>
                    <a href="/about" class="mr-5 font-medium leading-6 text-gray-600 hover:text-gray-900">About</a>
                    <a href="/dashboard"
                        class="mr-5 font-medium leading-6 text-gray-600 hover:text-gray-900">Dashboard</a>
                </nav>
            </div>

            <div class="inline-flex items-center ml-5 space-x-6 lg:justify-end">
                <a href="#"
                    class="text-base font-medium leading-6 text-gray-600 whitespace-no-wrap transition duration-150 ease-in-out hover:text-gray-900">
                    Sign in
                </a>
                <a href="#"
                    class="inline-flex items-center justify-center px-4 py-2 text-base font-medium leading-6 text-white whitespace-no-wrap bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600"
                    data-rounded="rounded-md" data-primary="indigo-600">
                    Sign up
                </a>
            </div>
        </div>
    </section>
    <!-- Homepage - Navigation - End  -->




    <?php
function home_content()
{
    // Your PHP, HTML, and JavaScript code for page home here.

?>
    <!-- Homepage - Hero - Start  -->
    <section class="relative w-full h-auto py-8 overflow-hidden bg-white sm:py-12 md:py-20 lg:py-32">
        <img src="https://cdn.devdojo.com/images/march2021/bg-gradient.png"
            class="absolute left-0 object-cover w-full h-full opacity-50 sm:opacity-100">
        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent to-white"></div>
        <div class="relative flex flex-col items-center justify-start h-full mx-auto px-14 max-w-7xl lg:flex-row">

            <div class="relative z-10 w-full h-full lg:w-1/2 xl:pr-12 2xl:pr-24">
                <div class="flex flex-col items-start justify-center h-full pt-12 lg:pt-0">
                    <h1
                        class="max-w-lg mx-auto text-4xl font-bold tracking-tight text-center text-gray-700 lg:mx-0 sm:text-5xl lg:text-6xl lg:text-left">
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">Dari&nbsp;ide→launching</span>
                        dalam 8 minggu
                    </h1>
                    <p class="max-w-md mx-auto mt-4 text-center text-gray-500 lg:mx-0 lg:text-left">Belajar bangun
                        startup impianmu dengan kurikulum yang sudah diuji lebih 2000+ startup. </p>
                    <div class="max-w-lg mx-auto lg:mx-0">
                        <div x-data="{ 
    modalOpen: false, 
    emailError: '', 
    email: '',
    validateEmail(event) {
        event.preventDefault();
        let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.email == '') {
            this.emailError = 'Email is required';
        } else if (!pattern.test(this.email)) {
            this.emailError = 'Please enter a valid email';
        } else {
            this.emailError = '';
            this.modalOpen = true;
            this.submitForm();
        }
    },
    submitForm() {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                email: this.email,
            }),
        });
    },
}" class="z-[9999]">
                            <form @submit="validateEmail">
                                <input x-model="email" type="text" placeholder="Your E-mail Address"
                                    class="mt-4 w-full py-4 pr-0 m-0 overflow-visible font-medium duration-300 border-2 border-gray-200 rounded-full outline-none cursor-text pl-7 focus:outline-none focus-within:border-purple-700 hover:border-gray-400"
                                    data-rounded="rounded-full">
                                <div></div><span x-text="emailError" class="text-red-600"></span>
                                <br />
                                <button type="submit"
                                    class=" h-12 px-8 mr-3 text-white mt-1 mb-4 bg-purple-700 rounded-full"
                                    data-rounded="rounded-full" data-primary="purple-700">Daftar / Masuk</button>
                            </form>
                            <!-- Modal starts here --><template x-teleport="body">
                                <div x-show="modalOpen"
                                    class="fixed top-0 left-0 flex items-center justify-center w-screen h-screen"
                                    style="z-index: 9999;" x-cloak>
                                    <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0" @click="modalOpen=false"
                                        class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                                    <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        class="relative w-full py-6 bg-white px-7 sm:max-w-lg   sm:rounded-lg">
                                        <div class="flex items-center justify-between pb-2">
                                            <h3 class="text-lg font-semibold">Modal Title</h3>
                                            <button @click="modalOpen=false"
                                                class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="relative w-auto">
                                            <p>This is placeholder text. Replace it with your own content.</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <!-- Modal ends here -->
                        </div>

                        <div class="hidden grid-cols-3 gap-8 sm:grid">
                            <div class="col-span-1 text-center lg:text-left">
                                <h4
                                    class="text-3xl font-bold tracking-tight text-transparent lg:text-4xl bg-clip-text bg-gradient-to-r from-blue-300 to-blue-500">
                                    +1M</h4>
                                <p class="text-sm font-semibold text-gray-400">Happy users</p>
                            </div>
                            <div class="col-span-1 text-center lg:text-left">
                                <h4
                                    class="text-3xl font-bold tracking-tight text-transparent lg:text-4xl bg-clip-text bg-gradient-to-r from-blue-300 to-blue-500">
                                    95%</h4>
                                <p class="text-sm font-semibold text-gray-400">Time saving</p>
                            </div>
                            <div class="col-span-1 text-center lg:text-left">
                                <h4
                                    class="text-3xl font-bold tracking-tight text-transparent lg:text-4xl bg-clip-text bg-gradient-to-r from-blue-300 to-blue-500">
                                    200+</h4>
                                <p class="text-sm font-semibold text-gray-400">Premium modules</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="relative z-10 w-full h-full px-10 pb-32 mt-16 lg:w-1/2 md:px-20 lg:px-5 xl:px-0 lg:pb-0 lg:mt-0 group">

                <div class="relative flex items-center justify-center w-full h-full">
                    <div class="relative w-full h-auto md:h-full lg:h-auto">
                        <img class="absolute right-0 z-10 object-cover object-center w-32 -mt-8 -mr-8 transition duration-300 transform rounded-md shadow-2xl md:w-40 lg:w-40 lg:top-0 lg:-mt-16 md:-mr-16 lg:-mr-6 md:rounded-lg lg:rounded-xl group-hover:scale-105"
                            src="https://cdn.devdojo.com/images/september2021/payment.png" alt="image" />
                        <img class="absolute bottom-0 left-0 z-10 object-cover object-center w-24 -mb-12 -ml-4 transition duration-300 transform rounded-md shadow-2xl md:w-32 lg:w-32 xl:w-40 md:-ml-12 md:rounded-lg lg:rounded-xl group-hover:scale-95"
                            src="https://cdn.devdojo.com/images/september2021/chart.png" alt="image" />
                        <div
                            class="relative w-full h-auto overflow-hidden transition duration-300 transform shadow-lg rounded-xl group-hover:scale-95">
                            <img class="w-full" src="https://cdn.devdojo.com/images/september2021/dashboard.png"
                                alt="image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Homepage - Hero - End  -->



    <?php
}

function about_content()
{
    // Your PHP, HTML, and JavaScript code for page 1 here.
?>

    <section class="h-auto bg-white">
        <div class="max-w-7xl mx-auto py-16 px-10 sm:py-24 sm:px-6 lg:px-8 sm:text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">about</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">Build your
                next great idea</p>
            <p class="max-w-3xl mt-5 mx-auto text-xl text-gray-500">Are you ready to start building the next great idea.
                You can start off by using our design components to help tell you story and showcase your great idea.
            </p>
        </div>
    </section>




    <?php
}

function dashboard_content()
{
    // Your PHP, HTML, and JavaScript code for page 2 here.
?>

    <h1>Selamat Datang di Dashboard</h1>

    <?php
}

// Basic routing based on URL
$request_uri = $_SERVER['REQUEST_URI'];

if ($request_uri === '/') {
    home_content();
} elseif ($request_uri === '/about') {
    about_content();
} elseif ($request_uri === '/dashboard') {
    dashboard_content();
} else {
    // Handle 404 Not Found
    echo '<h1>404 Not Found</h1>';
}
?>

    <!-- Homepage - Footer - Start  -->
    <section class="w-full bg-white">
        <div class="px-8 py-12 mx-auto max-w-7xl">
            <div class="grid grid-cols-2 gap-10 mb-3 md:grid-cols-3 lg:grid-cols-12 lg:gap-20">
                <div class="col-span-3">
                    <a href="#_" class="text-xl font-black leading-none text-gray-900 select-none logo">tails.</a>
                    <p class="my-4 text-xs leading-normal text-gray-500">
                        Beautifully hand-crafted components to help you build amazing pages.
                    </p>
                </div>
                <nav class="col-span-1 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-gray-400 uppercase">Product</p>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Features</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Integrations</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Documentation</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">FAQs</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Pricing</a>
                </nav>
                <nav class="col-span-1 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-gray-400 uppercase">About</p>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Our
                        Story</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Company</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Privacy</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Blog</a>
                </nav>
                <nav class="col-span-2 md:col-span-1 lg:col-span-2">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-gray-400 uppercase">Contact</p>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Advertising</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Press</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Email</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Partners</a>
                    <a href="#"
                        class="flex mb-3 text-sm font-medium text-gray-500 transition hover:text-gray-700 md:mb-2 hover:text-primary">Jobs</a>
                </nav>
                <div class="col-span-3">
                    <p class="mb-3 text-xs font-semibold tracking-wider text-gray-400 uppercase">SUBSCRIBE TO OUR
                        NEWSLETTER</p>
                    <form action="#" class="mb-2">
                        <div class="relative flex items-center overflow-hidden border border-gray-200 rounded-lg"
                            data-rounded="rounded-lg">
                            <input
                                class="w-full px-3 py-2 text-base leading-normal transition duration-150 ease-in-out bg-white appearance-none focus:outline-none"
                                type="email" placeholder="Enter your email" />
                            <button
                                class="px-3 py-2 text-xs text-sm font-medium text-center text-white no-underline bg-indigo-500 border-2 border-indigo-500"
                                data-primary="indigo-500" type="submit">Subscribe</button>
                        </div>
                    </form>
                    <p class="text-xs leading-normal text-gray-500">Get the latest updates and news about our service.
                    </p>
                </div>
            </div>
            <div
                class="flex flex-col items-start justify-between pt-10 mt-10 border-t border-gray-100 md:flex-row md:items-center">
                <p class="mb-6 text-sm text-left text-gray-600 md:mb-0">&copy; Copyright 2021 Tails. All Rights
                    Reserved.</p>
                <div class="flex items-start justify-start space-x-6 md:items-center md:justify-center">
                    <a href="#_" class="text-sm text-gray-600 transition hover:text-primary">Terms</a>
                    <a href="#_" class="text-sm text-gray-600 transition hover:text-primary">Privacy</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Homepage - Footer - End  -->
</body>

</html>