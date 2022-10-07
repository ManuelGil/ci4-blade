<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        @section('title') @show
    </title>

    @include('partials.head')

</head>

<body>

    <!-- HEADER: MENU + HEROE SECTION -->
    <header>

        @include('partials.header')

        @section('hero') @show

    </header>
    <!-- CONTENT -->

    @section('content') @show

    <!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

    @section('footer') @show


    <!-- SCRIPTS -->

    @include('partials.scripts')

    @section('script') @show

    <!-- -->

</body>

</html>
