@extends('admin.layouts.master')

@section('title')
    {{ $page_title }}
@endsection
@section('container')
    <div class="myy-table">
        <div class="myy-table__wrapper">


            <div class=" myy-table__header d-flex justify-content-between">
                <div class="myy-table__title">
                    <h5>{{ $info->title }}</h5>
                    <p>{{ $info->description }}</p>
                </div>
                <div class="float-right">
                    @can('blog-create')
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">
                            <i class="flaticon2-add"></i>
                            {{ $info->first_button_title }}
                        </a>
                    @endcan




                </div>
            </div>



            <div class="myy-table__body">
                @if ($data->count() > 0)
                    <!--begin: Datatable-->
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Banner</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Blog Category</th>
                                <th>Short Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $serial = 1;
                            @endphp

                            @foreach ($data as $row)
                                <tr >
                                     {{-- <td class="new-item-indicator">1</td> --}}

                                    <td>
                                        <div class="new-item-standalone-indicator new-item-success" data-new-text="New"></div>
                                        <span>1</span>
                                    </td>
                                     
                                    {{-- <td class="serial-content">
                                    
                                          
                                            <div class="new-item-denoter">
                                                <div class="blinking-circle"></div>
                                                <span class="new-text">New</span>
                                            </div>
                                    
                                        {{ $serial }}
                                    </td>    --}}

                                    <td>
                                        <div class="myy-item d-flex gap-2">
                                            <div class="myy-thumb thumb-md">
                                                <img src="@if($row->getMedia('banners')->isNotEmpty()) {{ asset($row->getFirstMediaUrl('banners')) }} @else {{ asset(avatarUrl()) }} @endif"
                                                alt="avatar">
                                            </div>
                                        </div>


                                    </td>
                                    <td><div class="new-item-standalone-indicator new-item-warning" data-new-text="Pickup"></div> {{ $row->title }}
                                    </td>
                                    <td><div class="new-item-standalone-indicator new-item-error" data-new-text="Hot"></div>{{ $row->slug }}
                                    </td>
                                    <td><div class="new-item-standalone-indicator" data-new-text="Pickup"></div>{{ $row->blogCategory?->title }}


                                    </td>
                                    <td>{{ $row->status }}
                                    </td>
                                    <td>{!! $row->short_description !!}
                                    </td>
                                    <td>
                                        <ul class="myy-action__list">
                                            <li class="myy-action">
                                                <a class="myy-action__item myy-action__item--success"
                                                    href="{{ route('admin.blogs.show', $row->id) }}">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                            </li>
                                            {{-- @can('blog-update')
                                                <li class="myy-action">
                                                    <a class="myy-action__item myy-action__item--warning"
                                                        href="{{ route('admin.blogs.edit', $row->id) }}">
                                                        <i class="lni lni-pencil-alt"></i>
                                                    </a>
                                                </li>
                                            @endcan --}}
                                            @can('blog-delete')
                                                <li class="myy-action">
                                                    <a onclick="deleteCrudItem(`{{ route('admin.blogs.destroy', $row->id) }}`)"
                                                        class="myy-action__item myy-action__item--danger" href="#">
                                                        <i class="lni lni-trash-can"></i>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>

                                    </td>
                                </tr>
                                @php
                                    $serial++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>


                    <!--end: Datatable-->
                @else
                    <div class="alert alert-custom alert-notice alert-light-success fade show mb-5 text-center"
                        role="alert">
                        <div class="alert-icon">
                            <i class="flaticon-questions-circular-button"></i>
                        </div>
                        <div class="alert-text text-dark">
                            No Data Found..!
                            <a href="{{ route($info->first_button_route) }}" class="btn btn-success">
                                <i class="flaticon2-add"></i>
                                Add Now
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
    @include('admin.components.modals.delete')
@endsection

@section('css')

   {{-- multi class blinker --}}
    {{-- <style>
        /* Style for the new item row */
        .new-item-row {
            background-color: #f0fff0; /* Light background for new row */
        }

        /* Container for serial number and the new item denoter */
        .serial-content {
            display: flex;
            align-items: center; /* Vertically align items in the middle */
            gap: 8px; /* Space between serial number and the denoter */
        }

        /* Container for the blinking circle and text */
        .new-item-denoter {
            display: flex; /* Use flexbox to align circle and text */
            flex-direction: column; /* Stack circle and text vertically */
            align-items: center; /* Center horizontally */
            justify-content: center; /* Center vertically */
            min-width: 35px; /* Ensure enough space for the denoter */
            text-align: center; /* Center text within its own space */
        }

        /* The blinking circle */
        .blinking-circle {
            width: 10px; /* Size of the circle */
            height: 10px;
            background-color: #4CAF50; /* Green color */
            border-radius: 50%; /* Make it a circle */
            animation: blink-effect 1.2s infinite alternate; /* Blinking animation */
            margin-bottom: 2px; /* Small space between circle and text */
        }

        /* The "New" text */
        .new-text {
            color: #4CAF50; /* Green text color */
            font-size: 0.7em; /* Slightly smaller for compactness */
            font-weight: bold;
        }

        /* Keyframes for the blinking animation */
        @keyframes blink-effect {
            0% {
                opacity: 0.3; /* Start almost transparent */
                box-shadow: 0 0 0 rgba(76, 175, 80, 0.7); /* Subtle initial glow */
            }
            50% {
                opacity: 1; /* Fully visible */
                box-shadow: 0 0 5px rgba(76, 175, 80, 0.9), 0 0 10px rgba(76, 175, 80, 0.6); /* Stronger glow */
            }
            100% {
                opacity: 0.3; /* Back to almost transparent */
                box-shadow: 0 0 0 rgba(76, 175, 80, 0.7); /* Subtle final glow */
            }
        }
    </style> --}}
{{-- <style>
        /* Basic table styling (same as before) */
    /* table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    }

    th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    }

    th {
    background-color: #f2f2f2;
    } */

    /* Style for the new item row (optional, for background color) */
    .new-item-row { /* You can still apply this to the tr if you want a background */
    background-color: #f0fff0;
    }

    /* The main class for the new item indicator */
    .new-item-indicator {
    position: relative; /* Essential for positioning pseudo-elements */
    /*
    * Increase padding-left to make room for the indicator.
    * Calculate it as: (circle_width + space_between_circle_and_text + text_width) + some_extra_margin
    * Let's say circle is 10px, text is ~30px, space is 5px, extra 5px = 50px
    */
    padding-left: 50px; /* Adjusted padding to accommodate the indicator */
    }

    /* Pseudo-element for the blinking circle */
    .new-item-indicator::before {
    content: ''; /* No content for the circle */
    position: absolute;
    left: 10px; /* Position from the left edge of the TD's padding box */
    top: 50%; /* Center vertically based on TD's height */
    transform: translateY(-50%); /* Adjust for perfect vertical centering */
    width: 10px; /* Size of the circle */
    height: 10px;
    background-color: #4CAF50; /* Green color */
    border-radius: 50%; /* Make it a circle */
    animation: blink-effect 1.2s infinite alternate; /* Blinking animation */
    z-index: 1; /* Ensure it's above other elements if any */
    }

    /* Pseudo-element for the "New" text */
    .new-item-indicator::after {
    content: 'New'; /* The "New" text */
    position: absolute;
    left: 0; /* Position from the left edge of the TD's padding box */
    top: calc(50% + 5px); /* Position slightly below the circle */
    transform: translateY(-50%); /* Adjust for perfect vertical centering of its own height */
    color: #4CAF50; /* Green text color */
    font-size: 0.7em; /* Slightly smaller for compactness */
    font-weight: bold;
    white-space: nowrap; /* Prevent "New" from wrapping */
    width: 30px; /* Give it a fixed width for centering */
    text-align: center; /* Center the text within its fixed width */
    z-index: 1; /* Ensure it's above other elements if any */
    }

    /* Keyframes for the blinking animation (same as before) */
    @keyframes blink-effect {
    0% {
        opacity: 0.3; /* Start almost transparent */
        box-shadow: 0 0 0 rgba(76, 175, 80, 0.7); /* Subtle initial glow */
    }
    50% {
        opacity: 1; /* Fully visible */
        box-shadow: 0 0 5px rgba(76, 175, 80, 0.9), 0 0 10px rgba(76, 175, 80, 0.6); /* Stronger glow */
    }
    100% {
        opacity: 0.3; /* Back to almost transparent */
        box-shadow: 0 0 0 rgba(76, 175, 80, 0.7); /* Subtle final glow */
    }
    }

 
</style> --}}
@endsection
@section('js')
    @parent
    {{-- SCRIPT --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Example: Get the second row in the tbody (assuming it's the new one)
        const newRow = document.querySelector('tbody tr:nth-child(2)'); // Adjust selector as needed

            if (newRow) {
                newRow.classList.add('new-item-row');
            }
        });
    </script>
@endsection
