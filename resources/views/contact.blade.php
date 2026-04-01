@extends('layout')

@section('title', 'Contact – KSB homes Design + Construct')
@section('meta_description', 'Enquire about luxury homes, knockdown rebuilds, and development projects with KSB homes.')

@php
    $lf = config('lead_form');
    $oldLooking = old('looking_to_do', []);
    if (! is_array($oldLooking)) {
        $oldLooking = [];
    }
    $showDevSection = count(array_intersect($oldLooking, $lf['dev_triggers'] ?? [])) > 0
        || old('project_type') === 'Multi-dwelling / Development'
        || old('project_goal') === 'Development for profit';
@endphp

@section('content')

    <section class="story-hero" aria-label="Contact">
        <div class="story-hero__bg">
            @php
                $contactHeroCandidates = ['contact-hero.jpg', 'contact-hero.jpeg', 'contact-hero.webp'];
                $contactHeroUrl = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&h=900&fit=crop';
                foreach ($contactHeroCandidates as $file) {
                    if (file_exists(public_path('assets/images/' . $file))) {
                        $contactHeroUrl = asset('assets/images/' . $file);
                        break;
                    }
                }
            @endphp
            <img src="{{ $contactHeroUrl }}" alt="Luxury residential architecture" class="story-hero__img" width="1600" height="900">
            <div class="story-hero__overlay" aria-hidden="true"></div>
        </div>
    </section>

    <section class="contact-details-bar" aria-label="Address and contact">
        <div class="contact-details-bar__inner">
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Address</span>
                <span class="contact-details-bar__value">Wahroonga Sydney NSW</span>
            </div>
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Phone</span>
                <a href="tel:+61421670636" class="contact-details-bar__value contact-details-bar__link">0421670636</a>
            </div>
            <div class="contact-details-bar__item">
                <span class="contact-details-bar__label">Instagram</span>
                <a href="https://www.instagram.com/ksbhomes/" class="contact-details-bar__value contact-details-bar__link" target="_blank" rel="noopener noreferrer">@ksbhomes</a>
            </div>
        </div>
    </section>

    <section class="section section--page section--about contact-page contact-page--lead" aria-labelledby="contact-heading">
        <div class="section__inner contact-grid contact-grid--lead">
            <div class="contact-info">
                <p class="section__label">Contact</p>
                <h1 id="contact-heading" class="section__title section__title--small">Enquire Now</h1>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Address</h2>
                    <p class="contact-info__text">Wahroonga Sydney NSW</p>
                </div>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Phone</h2>
                    <p class="contact-info__text"><a href="tel:+61421670636">0421670636</a></p>
                </div>

                <div class="contact-info__block">
                    <h2 class="contact-info__heading">Instagram</h2>
                    <p class="contact-info__text"><a href="https://www.instagram.com/ksbhomes/" target="_blank" rel="noopener noreferrer">@ksbhomes</a></p>
                </div>
            </div>

            <div class="contact-form lead-form">
                <p class="lead-form__headline">Luxury home &amp; development projects from $1M+</p>
                <p class="contact-form__intro lead-form__intro">
                    Tell us about your project. We’ll respond to serious enquiries promptly.
                </p>

                @if (session('contact_success'))
                    <p class="contact-form__message contact-form__message--success">
                        {{ session('contact_success') }}
                    </p>
                @endif

                @if (session('contact_error'))
                    <p class="contact-form__message contact-form__message--error" role="alert">
                        {{ session('contact_error') }}
                    </p>
                @endif

                @if ($errors->any())
                    <div class="lead-form__validation-summary" role="alert">
                        <p class="lead-form__validation-summary-title">Please fix the following:</p>
                        <ul class="lead-form__validation-summary-list">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('contact.submit') }}" class="contact-form__form lead-form__form" enctype="multipart/form-data" novalidate id="ksb-lead-form">
                    @csrf

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">1. Contact details</legend>

                        <div class="contact-form__field">
                            <label for="full_name" class="contact-form__label">Full name *</label>
                            <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" class="contact-form__input" required autocomplete="name">
                            @error('full_name')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="contact-form__field contact-form__field--half">
                            <label for="phone" class="contact-form__label">Phone number *</label>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="contact-form__input" required autocomplete="tel">
                            @error('phone')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="contact-form__field contact-form__field--half">
                            <label for="email" class="contact-form__label">Email address *</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="contact-form__input" required autocomplete="email">
                            @error('email')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="contact-form__field">
                            <label for="suburb_postcode" class="contact-form__label">Suburb / postcode *</label>
                            <input id="suburb_postcode" type="text" name="suburb_postcode" value="{{ old('suburb_postcode') }}" class="contact-form__input" required autocomplete="address-level2">
                            @error('suburb_postcode')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">2. What are you looking to do? *</legend>
                        <p class="lead-form__hint">Select all that apply.</p>
                        <div class="lead-form__checkbox-grid" role="group" aria-label="Project interests">
                            @foreach ($lf['looking_options'] as $opt)
                                <label class="lead-form__checkbox-item">
                                    <input type="checkbox" name="looking_to_do[]" value="{{ $opt }}"
                                        class="lead-form__checkbox-input js-looking-trigger"
                                        data-dev-trigger="{{ in_array($opt, $lf['dev_triggers'], true) ? '1' : '0' }}"
                                        {{ in_array($opt, $oldLooking, true) ? 'checked' : '' }}>
                                    <span class="lead-form__checkbox-text">{{ $opt }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('looking_to_do')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                        @error('looking_to_do.*')
                            <p class="contact-form__error">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">3. Land status</legend>
                        <div class="contact-form__field">
                            <span class="contact-form__label">Do you own the land? *</span>
                            <div class="lead-form__inline-radios">
                                <label class="lead-form__radio-item"><input type="radio" name="land_owner" value="yes" {{ old('land_owner') === 'yes' ? 'checked' : '' }} required> Yes</label>
                                <label class="lead-form__radio-item"><input type="radio" name="land_owner" value="no" {{ old('land_owner') === 'no' ? 'checked' : '' }}> No</label>
                            </div>
                            @error('land_owner')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="contact-form__field">
                            <label for="site_address" class="contact-form__label">Site address <span class="lead-form__optional">(if applicable)</span></label>
                            <input id="site_address" type="text" name="site_address" value="{{ old('site_address') }}" class="contact-form__input" autocomplete="street-address">
                            @error('site_address')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">4. Project type *</legend>
                        <div class="contact-form__field">
                            <label for="project_type" class="visually-hidden">Project type</label>
                            <select id="project_type" name="project_type" class="contact-form__input contact-form__select js-project-type" required>
                                <option value="">Select project type</option>
                                @foreach ($lf['project_types'] as $pt)
                                    <option value="{{ $pt }}" {{ old('project_type') === $pt ? 'selected' : '' }}>{{ $pt }}</option>
                                @endforeach
                            </select>
                            @error('project_type')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">5. Budget *</legend>
                        <div class="contact-form__field">
                            <label for="budget" class="visually-hidden">Budget</label>
                            <select id="budget" name="budget" class="contact-form__input contact-form__select" required>
                                <option value="">Select budget range</option>
                                @foreach ($lf['budgets'] as $b)
                                    <option value="{{ $b }}" {{ old('budget') === $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                            @error('budget')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">6. Timeline *</legend>
                        <div class="contact-form__field">
                            <label for="timeline" class="visually-hidden">Timeline</label>
                            <select id="timeline" name="timeline" class="contact-form__input contact-form__select" required>
                                <option value="">Select timeline</option>
                                @foreach ($lf['timelines'] as $t)
                                    <option value="{{ $t }}" {{ old('timeline') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('timeline')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">7. Project stage *</legend>
                        <div class="contact-form__field">
                            <label for="project_stage" class="visually-hidden">Project stage</label>
                            <select id="project_stage" name="project_stage" class="contact-form__input contact-form__select" required>
                                <option value="">Select stage</option>
                                @foreach ($lf['project_stages'] as $s)
                                    <option value="{{ $s }}" {{ old('project_stage') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('project_stage')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">8. Project goal *</legend>
                        <div class="contact-form__field">
                            <label for="project_goal" class="visually-hidden">Project goal</label>
                            <select id="project_goal" name="project_goal" class="contact-form__input contact-form__select js-project-goal" required>
                                <option value="">Select goal</option>
                                @foreach ($lf['project_goals'] as $g)
                                    <option value="{{ $g }}" {{ old('project_goal') === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                            @error('project_goal')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <div class="lead-form__section lead-form__section--dev-wrap">
                        <details class="lead-form__details" id="lead-form-dev-details" {{ $showDevSection ? 'open' : '' }}>
                            <summary class="lead-form__details-summary">
                                <span class="lead-form__section-title lead-form__section-title--inline">9. Development / joint venture</span>
                                <span class="lead-form__optional">(expand if this applies — required when development, JV, or multi-dwelling is selected)</span>
                            </summary>
                            <div class="lead-form__details-body">
                                <p class="lead-form__hint">Estimated project value, number of dwellings, and what you’re looking for (builder / developer / JV).</p>

                                <div class="contact-form__field">
                                    <label for="estimated_project_value" class="contact-form__label">Estimated project value <span class="lead-form__when-required">(required when applicable)</span></label>
                                    <input id="estimated_project_value" type="text" name="estimated_project_value" value="{{ old('estimated_project_value') }}" class="contact-form__input" inputmode="decimal" autocomplete="off">
                                    @error('estimated_project_value')
                                        <p class="contact-form__error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="contact-form__field">
                                    <label for="number_of_dwellings" class="contact-form__label">Number of dwellings <span class="lead-form__when-required">(required when applicable)</span></label>
                                    <input id="number_of_dwellings" type="text" name="number_of_dwellings" value="{{ old('number_of_dwellings') }}" class="contact-form__input" inputmode="numeric" autocomplete="off">
                                    @error('number_of_dwellings')
                                        <p class="contact-form__error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="contact-form__field">
                                    <label for="looking_for_partner" class="contact-form__label">Looking for <span class="lead-form__when-required">(required when applicable)</span></label>
                                    <select id="looking_for_partner" name="looking_for_partner" class="contact-form__input contact-form__select">
                                        <option value="">Select</option>
                                        @foreach ($lf['looking_for_partner'] as $lfOpt)
                                            <option value="{{ $lfOpt }}" {{ old('looking_for_partner') === $lfOpt ? 'selected' : '' }}>{{ $lfOpt }}</option>
                                        @endforeach
                                    </select>
                                    @error('looking_for_partner')
                                        <p class="contact-form__error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </details>
                    </div>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">10. How did you hear about us? *</legend>
                        <div class="contact-form__field">
                            <label for="hear_about_us" class="visually-hidden">How did you hear about us</label>
                            <select id="hear_about_us" name="hear_about_us" class="contact-form__input contact-form__select js-hear-about" required>
                                <option value="">Select</option>
                                @foreach ($lf['hear_about'] as $h)
                                    <option value="{{ $h }}" {{ old('hear_about_us') === $h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                            @error('hear_about_us')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="contact-form__field" id="lead-form-hear-other-wrap" {{ old('hear_about_us') === 'Other' ? '' : 'hidden' }}>
                            <label for="hear_about_other" class="contact-form__label">Please specify *</label>
                            <input id="hear_about_other" type="text" name="hear_about_other" value="{{ old('hear_about_other') }}" class="contact-form__input js-hear-other-input" {{ old('hear_about_us') === 'Other' ? 'required' : '' }}>
                            @error('hear_about_other')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">11. Message</legend>
                        <div class="contact-form__field">
                            <label for="message" class="contact-form__label">Tell us about your project</label>
                            <textarea id="message" name="message" rows="5" class="contact-form__input contact-form__textarea" placeholder="Scope, inspiration, questions…">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">12. Upload <span class="lead-form__optional">(optional)</span></legend>
                        <div class="contact-form__field">
                            <label for="plans" class="contact-form__label">Plans / drawings</label>
                            <input id="plans" type="file" name="plans" class="contact-form__file" accept=".pdf,.jpg,.jpeg,.png,.gif,.webp,.doc,.docx,application/pdf,image/*">
                            <p class="lead-form__hint">PDF, images, or Word. Max 15&nbsp;MB.</p>
                            @error('plans')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <fieldset class="lead-form__section">
                        <legend class="lead-form__section-title">13. Consent</legend>
                        <div class="contact-form__field contact-form__field--checkbox">
                            <label class="contact-form__checkbox-label lead-form__consent-label">
                                <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }} required>
                                I am serious about starting a project and agree to be contacted.
                            </label>
                            @error('consent')
                                <p class="contact-form__error">{{ $message }}</p>
                            @enderror
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn--primary contact-form__submit">Submit enquiry</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
(function() {
    var form = document.getElementById('ksb-lead-form');
    if (!form) return;

    var devDetails = document.getElementById('lead-form-dev-details');
    var lookingInputs = form.querySelectorAll('.js-looking-trigger');
    var projectType = form.querySelector('.js-project-type');
    var projectGoal = form.querySelector('.js-project-goal');

    function devTriggerFromCheckboxes() {
        for (var i = 0; i < lookingInputs.length; i++) {
            if (lookingInputs[i].checked && lookingInputs[i].getAttribute('data-dev-trigger') === '1') {
                return true;
            }
        }
        return false;
    }

    function devContextActive() {
        if (devTriggerFromCheckboxes()) return true;
        if (projectType && projectType.value === 'Multi-dwelling / Development') return true;
        if (projectGoal && projectGoal.value === 'Development for profit') return true;
        return false;
    }

    function syncDevDetails() {
        if (!devDetails) return;
        if (devContextActive()) {
            devDetails.open = true;
        }
    }

    for (var k = 0; k < lookingInputs.length; k++) {
        lookingInputs[k].addEventListener('change', syncDevDetails);
    }
    if (projectType) projectType.addEventListener('change', syncDevDetails);
    if (projectGoal) projectGoal.addEventListener('change', syncDevDetails);

    var hearSelect = form.querySelector('.js-hear-about');
    var hearOtherWrap = document.getElementById('lead-form-hear-other-wrap');
    var hearOtherInput = form.querySelector('.js-hear-other-input');

    function syncHearOther() {
        if (!hearSelect || !hearOtherWrap || !hearOtherInput) return;
        var isOther = hearSelect.value === 'Other';
        hearOtherWrap.hidden = !isOther;
        hearOtherInput.required = isOther;
        if (!isOther) hearOtherInput.value = '';
    }

    if (hearSelect) hearSelect.addEventListener('change', syncHearOther);

    syncDevDetails();
    syncHearOther();
})();
</script>
@endpush
