const $ = jQuery;

export class PresentationForm {
    constructor() {
        this.$form = $('#presentation-form');
        this.$form.on('submit', this.onSubmit.bind(this));

        this.beginTabButton = this.$form.find('#begin-tab');
        this.stepOneButton = this.$form.find('#step-one-tab');
        this.stepTwoButton = this.$form.find('#step-two-tab');
        this.stepThreeButton = this.$form.find('#step-three-tab');
        this.stepFourButton = this.$form.find('#step-four-tab');
        this.stepFiveButton = this.$form.find('#step-five-tab');
        this.stepSixButton = this.$form.find('#step-six-tab');
        this.stepSevenButton = this.$form.find('#step-seven-tab');

        this.beginPresentationButton = this.$form.find('#presentation-script-select-button');

        this.beginTab = this.$form.find('#begin');
        this.stepOneTab = this.$form.find('#step-one');
        this.stepTwoTab = this.$form.find('#step-two');
        this.stepThreeTab = this.$form.find('#step-three');
        this.stepFourTab = this.$form.find('#step-four');
        this.stepFiveTab = this.$form.find('#step-five');
        this.stepSixTab = this.$form.find('#step-six');
        this.stepSevenTab = this.$form.find('#step-seven');

        this.beginPresentationButton.on('click', this.beginPresentation.bind(this));

    }

    onSubmit(e) {
        e.preventDefault();
        const data = this.$form.serializeArray();
        console.log(data);
    }

    beginPresentation() {
        // go to step one
        this.beginTabButton.removeClass('active');
        this.stepOneButton.addClass('active');
        this.beginTab.removeClass('active');
        this.stepOneTab.addClass('active');

        // hide begin tab
        this.beginTab.addClass('d-none');
        this.stepOneTab.removeClass('d-none');
        
    }
}