@php
    $title = __("Modification de l'immobilisation");
@endphp
@extends('layouts.admin')
@section('title', $title)
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Inter", sans-serif;
    }

    .formbold-main-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px;
    }

    .formbold-form-wrapper {
        margin: 0 auto;
        max-width: 550px;
        width: 100%;
        background: white;
    }

    .formbold-steps {
        padding-bottom: 18px;
        margin-bottom: 35px;
        border-bottom: 1px solid #DDE3EC;
    }

    .formbold-steps ul {
        padding: 0;
        margin: 0;
        list-style: none;
        display: flex;
        gap: 40px;
    }

    .formbold-steps li {
        display: flex;
        align-items: center;
        gap: 14px;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        color: #536387;
    }

    .formbold-steps li span {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #DDE3EC;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        color: #536387;
    }

    .formbold-steps li.active {
        color: #07074D;
        ;
    }

    .formbold-steps li.active span {
        background: #6A64F1;
        color: #FFFFFF;
    }

    .formbold-input-flex {
        display: flex;
        gap: 20px;
        margin-bottom: 22px;
    }

    .formbold-input-flex>div {
        width: 50%;
    }

    .form-control form-control-sm {
        width: 100%;
        padding: 13px 22px;
        border-radius: 5px;
        border: 1px solid #DDE3EC;
        background: #FFFFFF;
        font-weight: 500;
        font-size: 16px;
        color: #536387;
        outline: none;
        resize: none;
    }

    .form-control form-control-sm:focus {
        border-color: #6a64f1;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
    }

    .formbold-form-label {
        color: #07074D;
        font-weight: 500;
        font-size: 14px;
        line-height: 24px;
        display: block;
        margin-bottom: 10px;
    }

    .formbold-form-confirm {
        border-bottom: 1px solid #DDE3EC;
        padding-bottom: 35px;
    }

    .formbold-form-confirm p {
        font-size: 16px;
        line-height: 24px;
        color: #536387;
        margin-bottom: 22px;
        width: 75%;
    }

    .formbold-form-confirm>div {
        display: flex;
        gap: 15px;
    }

    .formbold-confirm-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #FFFFFF;
        border: 0.5px solid #DDE3EC;
        border-radius: 5px;
        font-size: 16px;
        line-height: 24px;
        color: #536387;
        cursor: pointer;
        padding: 10px 20px;
        transition: all .3s ease-in-out;
    }

    .formbold-confirm-btn {
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.12);
    }

    .formbold-confirm-btn.active {
        background: #6A64F1;
        color: #FFFFFF;
    }

    .formbold-form-step-1,
    .formbold-form-step-2,
    .formbold-form-step-3 {
        display: none;
    }

    .formbold-form-step-1.active,
    .formbold-form-step-2.active,
    .formbold-form-step-3.active {
        display: block;
    }

    .formbold-form-btn-wrapper {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 25px;
        margin-top: 25px;
    }

    .formbold-back-btn {
        cursor: pointer;
        background: #FFFFFF;
        border: none;
        color: #07074D;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        display: none;
    }

    .formbold-back-btn.active {
        display: block;
    }

    .formbold-btn {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 16px;
        border-radius: 5px;
        padding: 10px 25px;
        border: none;
        font-weight: 500;
        background-color: #6A64F1;
        color: white;
        cursor: pointer;
    }

    .formbold-btn:hover {
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
    }
</style>
@section('content')
    {{-- Contenu de la page --}}
    <div class="col-md-12">
        <!-- Collapsable Card Example -->
        <div class="card mb-4">
            <!-- Card Header - Accordion -->

            <!-- Card Content - Collapse -->
            <div class="content-form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="formbold-main-wrapper">
                                <!-- Author: FormBold Team -->
                                <!-- Learn More: https://formbold.com -->
                                    <form action="https://formbold.com/s/FORM_ID" method="POST">
                                        <div class="formbold-steps">
                                            <ul>
                                                <li class="formbold-step-menu1 active">
                                                    <span>1</span>
                                                    Informations de bases
                                                </li>
                                                <li class="formbold-step-menu2">
                                                    <span>2</span>
                                                    Autres Informations
                                                </li>
                                                <li class="formbold-step-menu3">
                                                    <span>3</span>
                                                    Détails de l'annonce
                                                </li>
                                            </ul>
                                        </div>

                                        @include('admin.immos.form')

                                        <div class="formbold-form-btn-wrapper">
                                            <button class="formbold-back-btn">
                                                Back
                                            </button>

                                            <button class="formbold-btn">
                                                Next Step
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1675_1807)">
                                                        <path
                                                            d="M10.7814 7.33312L7.20541 3.75712L8.14808 2.81445L13.3334 7.99979L8.14808 13.1851L7.20541 12.2425L10.7814 8.66645H2.66675V7.33312H10.7814Z"
                                                            fill="white" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1675_1807">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                            </div>


                            {{-- <form method="POST" action="{{ route($_espace.'.immos.update',$immo->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="form-group row">
                                    @include('admin.immos.form')
                                </div>
                                <div class="form-group row  mb-0">
                                    <div class="col-lg-4 col-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('general.valider') }}
                                        </button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
    {{-- Fin contenu --}}
@endsection

@section('scriptBottom')
    <script>
        const stepMenuOne = document.querySelector('.formbold-step-menu1')
        const stepMenuTwo = document.querySelector('.formbold-step-menu2')
        const stepMenuThree = document.querySelector('.formbold-step-menu3')

        const stepOne = document.querySelector('.formbold-form-step-1')
        const stepTwo = document.querySelector('.formbold-form-step-2')
        const stepThree = document.querySelector('.formbold-form-step-3')

        const formSubmitBtn = document.querySelector('.formbold-btn')
        const formBackBtn = document.querySelector('.formbold-back-btn')

        formSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault()
            if (stepMenuOne.className == 'formbold-step-menu1 active') {
                event.preventDefault()

                stepMenuOne.classList.remove('active')
                stepMenuTwo.classList.add('active')

                stepOne.classList.remove('active')
                stepTwo.classList.add('active')

                formBackBtn.classList.add('active')
                formBackBtn.addEventListener("click", function(event) {
                    event.preventDefault()

                    stepMenuOne.classList.add('active')
                    stepMenuTwo.classList.remove('active')

                    stepOne.classList.add('active')
                    stepTwo.classList.remove('active')

                    formBackBtn.classList.remove('active')

                })

            } else if (stepMenuTwo.className == 'formbold-step-menu2 active') {
                event.preventDefault()

                stepMenuTwo.classList.remove('active')
                stepMenuThree.classList.add('active')

                stepTwo.classList.remove('active')
                stepThree.classList.add('active')

                formBackBtn.classList.add('active')
                formSubmitBtn.textContent = 'Submit'
                                formBackBtn.addEventListener("click", function(event) {
                    event.preventDefault()

                    stepMenuOne.classList.add('active')
                    stepMenuTwo.classList.remove('active')

                    stepOne.classList.add('active')
                    stepTwo.classList.remove('active')

                    formBackBtn.classList.remove('active')

                })
            } else if (stepMenuThree.className == 'formbold-step-menu3 active') {
                formBackBtn.classList.add('active')
                document.querySelector('form').submit()
                formBackBtn.addEventListener("click", function(event) {
                    event.preventDefault()

                    stepMenuOne.classList.add('active')
                    stepMenuTwo.classList.remove('active')

                    stepOne.classList.add('active')
                    stepTwo.classList.remove('active')

                    formBackBtn.classList.remove('active')

                })
            }
        })
    </script>
@endsection
