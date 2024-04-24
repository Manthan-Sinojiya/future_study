<?php
include("homehead.php");
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("location:../login.php");
    exit;
}
?>
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Future Study Hub </h1>
                <div class="d-flex justify-content-center usp">
                    <p>In order to succeed, we must first <i><b>Believe</b></i> that we can</p>
                </div>
                <a href="./exam.php" class="btn purple">TAKE IELTS
                    <img class="img-fluid" src="../assets/img/arrow.webp" alt="->">
                </a>
            </div>
        </div>
    </div>
</section>

<section class="usp">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center spacer">
                <h2> Online <i>Classes For <i>IELTS</i> Learning.</h2>
                <p>
                    <i>
                        Score higher, go farther! Elevate your IELTS with a tailored course for Listening, Reading, Writing, Speaking. Achieve academic and immigration goals.
                    </i>
                </p>
            </div>
        </div>
        <div class="row gx-5">
            <div class="col-md-6 col-lg-6">
                <div class="wrapper">
                    <picture>
                        <img class="img-fluid" src="../assets/img/icons8-reading-48.png" alt="Reading">
                    </picture>
                    <h3>Reading</h3>
                    <p>
                        IELTS Reading assesses your ability to comprehend and analyze written information through various question types.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="wrapper">
                    <picture>
                        <img class="img-fluid" src="../assets/img/icons8-listening-48.png" alt="Listening">
                    </picture>
                    <h3>Listening</h3>
                    <p>
                        Effective listening skills allow you to be objective and cut through the tensed emotions to really determine right from wrong.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="wrapper">
                    <picture>
                        <img class="img-fluid" src="../assets/img/icons8-writing-48.png" alt="Writing">
                    </picture>
                    <h3>Writing</h3>
                    <p>
                        Plan your time, read the question, highlight the issues to address, outline your response, expand on your ideas, plan how you will connect your ideas, and write your first draft.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="wrapper">
                    <picture>
                        <img class="img-fluid" src="../assets/img/icons8-lecturer-48.png" alt="Speaking">
                    </picture>
                    <h3>Speaking</h3>
                    <p>
                        IELTS Speaking evaluates your ability to communicate fluently, coherently, and effectively in English, assessing pronunciation, vocabulary, grammar, and interactive skills.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-7">
                <div class="content_wrapper mb-5 mb-lg-0">
                    <h2>
                        Modules
                    </h2>
                    <p><span class="ielts">IELTS</span> has two test types - <span>IELTS General Training</span> and <span>IELTS Academic</span>.
                    <h3> IELTS Academic</h3>
                    <p>IELTS Academic is suitable for candidates who require IELTS for academic purposes, mostly to study at undergraduate or postgraduate levels or for professional registration in an English speaking environment.</p>
                    <h3>IELTS General</h3>
                    <p>IELTS General Training is suited for those who need English language proficiency to show qualifications to study below a degree level, employment and migration to English speaking countries such as Australia, the UK, the USA, Canada, New Zealand, Ireland, etc.</p>


                </div>
            </div>
            <div class="col-lg-5 order-lg-first">
                <div class="form_wrapper mb-5 mb-lg-0">
                    <h2>IELTS</h2>
                    <p>
                    Test takers opting for IELTS on Computer take the Listening, Reading, and Writing sections on a computer.IELTS on Computer gives you the convenience to choose from multiple test dates and slots, you can expect your results within 3-5 days. 
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="soft">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content_wrapper">
                        <div class="row gx-5">
                            <div class="col-md-6">
                                <h2>
                                    <span class="subtitle">Install 400+ applications with a few clicks</span>
                                    Softaculous Installer
                                </h2>
                                <p>
                                    Use the Softaculous automatic script installer to install one of over 400 scripts,
                                    applications and CMS like WordPress with only a few clicks, and automatically keep them
                                    up to date.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <ul class="row bullets">
                                    <li class="row">Setting up software, like WordPress, has never been easier</li>
                                    <li class="row">Choose from over 400 available scripts</li>
                                    <li class="row">The easiest way to keep all your software up to date</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>
                        <span class="subtitle">Still have doubts? </span>
                        FAQ - Common questions before registration
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Is your hosting really free?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Yes, you can host your website without having to pay. Ever.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How long does it takes to setup my account?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Forget about waiting lists, InfinityFree accounts are automatically created in minutes.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    For how long is the free hosting valid?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        InfinityFree is free forever! There is no time limit for free hosting.
                                        You can sign up whenever you want and use it for as long as you want!
                                        Some people have been hosting their websites with us for years,
                                        without ever paying anything!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Why do you provide free hosting?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        InfinityFree provides free hosting, because we believe everyone should have the
                                        opportunity to build a presence online. Regardless of who you are, where you are
                                        and what your budget is, we believe you should be able to have a website.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Can I get a free subdomain?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        You can use as many free subdomains, like yourname.great-site.net or yourname.rf.gd, as you want. All for free!
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Can I host my own domains?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Yes, you can host your own domain name on InfinityFree.
                                        We don't provide domain registration services ourselves,
                                        but can easily use your own domain registered elsewhere with us.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Will you put ads on my site?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Never! We earn enough using the ads on our main site and control panel to cover
                                        the costs of free hosting.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Is InfinityFree a demo, trial or sample for premium hosting?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>
                                        Absolutely not! InfinityFree is fully featured, completely free website hosting.
                                        We provide promotional offers for alternative, premium services for people
                                        looking for more, but their services are very different. InfinityFree is not a
                                        representation of these offers.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <section class="payoff">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Forget the stereotypes of free hosting!</h2>
                </div>
            </div>
        </div>
    </section>-->
<?php
include("homefoot.php");
?>

<script type="text/javascript" src="../script1.js"></script>
</body>

</html>