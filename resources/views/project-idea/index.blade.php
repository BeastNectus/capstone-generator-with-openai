@extends('layouts.app')

@section('content')
<div class="container p-5">
    <div class="text-center">
        <h1 class="website-title mb-2">Capstone Project Idea Generator</h1>
        <p class="website-description">Effortlessly create unique capstone ideas.</p>
    </div>
    <div class="row g-4 mt-4">
        <!-- Filter Section -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-center">Filters</h5>
                </div>
                <div class="card-body">
                    <form id="ideaGeneratorForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Industry</label>
                            <select name="industry_id" class="form-select">
                                <option disabled selected>Select an Industry</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Project Type</label>
                            <select name="project_type_id" class="form-select">
                                <option disabled selected>Select a Project Type</option>
                                @foreach($projectTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Difficulty</label>
                            <select name="difficulty" class="form-select">
                                <option disabled selected>Select Difficulty Level</option>
                                @foreach($difficulties as $difficulty)
                                    <option value="{{ $difficulty }}">{{ $difficulty }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="generateButton" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-magic me-2"></i>Generate Idea
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center developed-by">Developed by: <a href="https://www.linkedin.com/in/johnmamanao" target="_blank" class="ms-2"><b class="developer">John Mamanao</b></a></p>
        </div>

        <!-- Result Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div id="result-placeholder-container" class="d-flex justify-content-center align-items-center p-4" style="height: 320px;">
                    <h3 id="result-placeholder" class="text-muted text-center">
                        Your capstone idea will be shown here...
                    </h3>
                </div>

                <div id="projectContent" style="display: none;">
                    <div class="card-body">
                        <h3 id="projectTitle" class="text-dark fw-bold"></h3>
                        <div id="projectDescription" class="mt-3"></div>

                        <!-- Programming Languages -->
                        <div id="programmingLanguages" class="mt-4"></div>

                        <!-- Suggested Roles -->
                        <div id="suggestedRoles" class="mt-4"></div>

                        <!-- Similar Projects -->
                        <div id="similarProjects" class="mt-4"></div>

                        <!-- Project Timeline -->
                        <div id="projectTimeline" class="mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center developed-by2">Developed by: <a href="https://www.linkedin.com/in/johnmamanao" target="_blank" class="ms-2"><b class="developer">John Mamanao</b></a></p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#ideaGeneratorForm').on('submit', function(e) {
            e.preventDefault();

            $('#generateButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Generating...');

            $.ajax({
                url: '{{ route("project-idea.generate") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#result-placeholder-container').remove();
                    $('#result-placeholder').hide();
                    $('#projectContent').show();

                    $('#projectTitle').text(response.title);
                    $('#projectDescription').html('<p>' + response.description + '</p>');

                    // Programming Languages
                    $('#programmingLanguages').html('<h4 class="fw-bold">Programming Languages:</h4><p>' +
                        response.programming_languages.join(', ') + '</p>');

                    // Suggested Roles
                    $('#suggestedRoles').html('<h4 class="fw-bold">Suggested Roles:</h4><p>' +
                        response.suggested_roles.join(', ') + '</p>');

                    // Similar Projects
                    let similarProjectsHtml = '<h4 class="fw-bold">Similar Projects:</h4><div class="col g-2 mt-3">';
                    response.similar_projects.forEach(project => {
                        similarProjectsHtml += `
                            <div>
                                <a href="${project.link}" class="text-primary d-block project-link mt-1" target="_blank">
                                    ${project.name} <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        `;
                    });
                    similarProjectsHtml += '</div>';
                    $('#similarProjects').html(similarProjectsHtml);

                    // Timeline
                    let timelineHtml = '<h4 class="fw-bold">Project Timeline:</h4>';
                    timelineHtml += `
                        <ul class="list-group mt-3">
                            <li class="list-group-item"><strong>Planning Phase:</strong> ${response.timeline.planning_phase}</li>
                            <li class="list-group-item"><strong>Development Phase:</strong> ${response.timeline.development_phase}</li>
                            <li class="list-group-item"><strong>Testing Phase:</strong> ${response.timeline.testing_phase}</li>
                            <li class="list-group-item"><strong>Deployment Phase:</strong> ${response.timeline.deployment_phase}</li>
                            <li class="list-group-item"><strong>Total Duration:</strong> ${response.timeline.total_duration}</li>
                        </ul>
                    `;
                    $('#projectTimeline').html(timelineHtml);
                },
                error: function(xhr) {
                    alert('Error generating idea. Please try again.');
                },
                complete: function() {
                    $('#generateButton').prop('disabled', false).html('<i class="fas fa-magic"></i> Generate Idea');
                }
            });
        });
    });
</script>
@endpush

