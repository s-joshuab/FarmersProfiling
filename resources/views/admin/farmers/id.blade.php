@extends('layouts.index')
@section('content')
    <div id="to_print">
        <style>
            .page {
                width: 320px;
                height: 200px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
                margin-right: 20px;
                margin-bottom: 20px;
                display: inline-block;
                vertical-align: top;
                page-break-inside: avoid;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .header h4 {
                margin: 0;
                font-size: 16px;
            }

            .design {
                height: 2px;
                background-color: #000;
                margin: 20px 0;
            }

            .signature-line {
                border-bottom: 1px solid #000;
                margin-top: 25px;
                width: 26%;
                margin-left: 5px;
            }

            .picture-square {
                width: 96px;
                height: 96px;
                background-color: #ccc;
                margin: 0 auto;
            }
        </style>

        <div class="row">
            <div class="card" id = "to_print">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="page mt-3 shadow-sm container"
                            style="background-image: url('{{ asset('assets/img/eto na.png') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; width: 410px;">
                            <div class="header">
                                <img src="{{ asset('assets/img/12345.jpg') }}" alt="Logo"
                                    style="max-width: 50px; margin-left: -350px; margin-top: 5px; border-radius: 50%;">
                                <h4 style="font-size: 12px; margin-top: -50px; font-weight: bold;">Republic of the
                                    Philippines</h4>
                                <h4 style="font-size: 12px; font-weight: bold;">Municipality of La Union</h4>
                                <h4 style="font-size: 12px; font-weight: bold;">Bayan ng Balaoan</h4>
                            </div>

                            <hr class="design" style="margin-top: -15px;">


                            <div class="picture-square" style="margin-left: 10px; margin-top: -15px;"></div>
                            <div class="signature-line" style="margin-left: 10px; margin-top: 10px;"></div>
                            <div class="content" style="position: relative; margin-left: -20px;">


                                {{-- <p
                                            style="font-size: 12px; font-weight: bold; margin-left: 180px; margin-top: -130px;">
                                            Municipal Agriculture Office</p> --}}
                                            <p style="font-size: 12px; font-weight: bold; margin-left: -20px; margin-top: -120px;"></p>

                                            <p style="font-size: 12px; font-weight: bold; margin-left: 142px; margin-top: -10px; text-transform: uppercase;">
                                                {{ $farmers->fname }} {{ $farmers->sname }}
                                            </p>

                                            <p style="font-size: 11px; font-weight: bold; margin-left: 142px; margin-top: -20px;">
                                                {{ $farmers->barangay->barangays }} , {{ $farmers->municipalities_id }}, {{ $farmers->provinces_id }}
                                            </p>

                                            <p style="font-size: 11px; font-weight: bold; margin-left: 142px; margin-top: -2px;">
                                                ID Number:<br> {{ $farmers->farmersNumbers->first()->farmersnumber }}
                                            </p>

                                            <p style="font-size: 11px; font-weight: bold; margin-left: 230px; margin-top: -50px;">
                                                Sex:<br> {{ $farmers->sex }}
                                            </p>

                                            <div class="row">
                                                <p style="font-size: 11px; font-weight: bold; margin-left: 142px; margin-top: -10px;">
                                                    Contact No:<br> {{ $farmers->number }}
                                                </p>

                                                <p style="font-size: 11px; font-weight: bold; margin-left: 230px; margin-top: -49px;">
                                                    Civil Status:<br> {{ $farmers->civil_status->status }}
                                                </p>
                                            </div>

                                <p style="font-size: 10px; font-weight: bold; margin-left: 52px; margin-top: -28px;">
                                    Signature</p>

                                <div
                                    style="position: absolute; margin-top: -115px; right: -10px; width: 80px; height: 80px; ">
                                    <img src="data:image/png;base64,{{ base64_encode(
                                        QrCode::format('png')->size(200)->generate(
                                                $farmers->farmersNumbers->first()->farmersnumber .
                                                    "\n" .
                                                    $farmers->fname .
                                                    ' ' .
                                                    $farmers->sname .
                                                    "\n" .
                                                    $farmers->barangay->barangays .
                                                    ' ' .
                                                    $farmers->municipalities_id .
                                                    ' ' .
                                                    $farmers->provinces_id,
                                            ),
                                    ) }}"
                                        style="width: 80px; height: 80px;">
                                </div>


                            </div>
                        </div>


                        <div class="page mt-3 shadow-sm container"
                            style="background-image: url('{{ asset('assets/img/eto na.png') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; width: 410px;">
                            <div class="content">

                                    <h4 class="text-center mt-2"
                                        style="font-size: 14px; font-weight: bold; ">Person To
                                        Notify In Case of Emergency:</h4>
                                    {{-- <hr class="design" style="margin-top: -8px;"> --}}
                                    <div class="row text-center" style="margin-top: 10px;">
                                        <p style="margin: 0px 0; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                                            {{ $farmers->mother }}</p>
                                        {{-- <p style="margin: 0px 0; font-size: 12px; font-weight: bold;">Relationship: Sister</p> --}}
                                        <p style="margin: 0px 0; margin-bottom: 0; font-size: 11px; font-weight: bold;">
                                            {{ $farmers->emergency }}</p>
                                    </div>

                                </div>

                                {{-- <hr class="design" style="margin-top: -1px;"> --}}
                                <h4 class="text-center" style="font-size: 12px; font-weight: bold; margin-top: 15px;">
                                    C E R T I F I C A T I O N</h4>
                                <p class="text-center" style="font-size: 11px; font-weight: bold; margin-top: -10px;">
                                    This is to certify that the person whose name, photograph, and signature appear
                                    herein is a duly bonafide farmer of Balaoan, La Union
                                </p>
                                <!-- Use a table for proper alignment -->
                                <table style="width: 100%; margin-top: 10px;">
                                    <tr>
                                        <td style="width: 50%; text-align: center;">
                                            <div class="signature-line" style="width: 80%; margin: 0 auto;"></div>
                                            @foreach ($users as $user)
                                                @if ($user->username === 'admin')
                                                    <h5 style="font-size: 12px; font-weight: bold; margin: 10px 0;">
                                                        {{ $user->name }}
                                                    </h5>
                                                @endif
                                            @endforeach



                                            <h5 style="font-size: 11px; margin-top: -10px; font-weight: bold; ">OIC, Municipal Agriculturist
                                            </h5>
                                        </td>
                                        <td style="width: 50%; text-align: center;">
                                            <div class="signature-line" style="width: 80%; margin: 0 auto;"></div>
                                            @foreach ($users as $user)
                                                @if ($user->username === 'mayor')
                                                    <h5 style="font-size: 11px; font-weight: bold; margin: 10px 0;">
                                                        {{ $user->name }}
                                                    </h5>
                                                @endif
                                            @endforeach
                                            <h5 style="font-size: 11px; margin-top: -10px; font-weight: bold;">Municipal Mayor</h5>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-lg btn-primary print_no" onclick="print_this('to_print')">Print/Save</button>

    <script>
        function print_this(id) {
            var prtContent = document.getElementById(id);
            var WinPrint = window.open('', '', 'left=0,top=0,width=1300,height=1100,toolbar=0,scrollbars=0,status=0');

            // WinPrint.document.write(
            //    '<html><head><title>Print</title><link rel="stylesheet" href="path/to/your/external.css" type="text/css"></head><body>'
            //  );

            WinPrint.document.write(
                '<html><head><title>Print</title><link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"></head><body>'
            );
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.write('</body></html>');
            WinPrint.document.close();

            WinPrint.setTimeout(function() {
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            }, 1000);
        }
    </script>
@endsection
