var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
function createStateStore(_a) {
    var survey = _a.survey, nonce = _a.nonce, apiBase = _a.apiBase;
    return Vue.observable({
        config: {
            nonce: nonce,
            apiBase: apiBase
        },
        survey: survey,
        sectionUid: survey.sections[0].uid,
        entry: {},
        lastEntry: {},
        fieldsErrors: {},
        globalError: '',
        loading: {},
        navigation: [survey.sections[0].uid]
    });
}
function createStateActions(store) {
    return {
        dismissFieldsErrors: function () {
            store.fieldsErrors = {};
        },
        dismissErrors: function () {
            this.dismissFieldsErrors();
            this.dismissGlobalError();
        },
        dismissGlobalError: function () {
            store.globalError = null;
        },
        getFieldError: function (fieldUid) {
            return store.fieldsErrors[fieldUid] || '';
        },
        getGlobalError: function () {
            return store.globalError || '';
        },
        setGlobalError: function (error) {
            store.globalError = error;
        },
        setFieldError: function (fieldUid, error) {
            Vue.set(store.fieldsErrors, fieldUid, error);
        },
        setSectionUid: function (sectionUid) {
            if (sectionUid !== store.navigation[store.navigation.length - 1]) {
                store.navigation.push(sectionUid);
            }
            store.sectionUid = sectionUid;
            this.persist();
        },
        getSectionUid: function () {
            return store.sectionUid;
        },
        getSection: function (sectionUid) {
            return store.survey.sections.find(function (section) { return section.uid === sectionUid; });
        },
        getCurrentSection: function () {
            return store.survey.sections[this.getSectionIndex()];
        },
        getNextSection: function () {
            return store.survey.sections[this.getSectionIndex() + 1];
        },
        getPreviousSection: function () {
            return store.survey.sections[this.getSectionIndex() - 1];
        },
        getSectionIndex: function () {
            return store.survey.sections.findIndex(function (section) { return section.uid === store.sectionUid; });
        },
        getFirstSection: function () {
            return store.survey.sections[0] || null;
        },
        getLastSection: function () {
            return store.survey.sections[store.survey.sections.length - 1] || null;
        },
        isSectionUid: function (sectionUid) {
            return store.sectionUid === sectionUid;
        },
        isFirstSection: function () {
            var _a;
            return ((_a = this.getPreviousSection()) === null || _a === void 0 ? void 0 : _a.uid) !== 'welcome';
        },
        isLastSection: function () {
            var _a;
            return ((_a = this.getNextSection()) === null || _a === void 0 ? void 0 : _a.uid) === 'thankyou';
        },
        isStarted: function () {
            return this.getSectionIndex() > 0;
        },
        isFinished: function () {
            return store.sectionUid === 'thankyou';
        },
        navigateToNextSection: function () {
            var _a;
            this.setSectionUid((_a = this.getNextSection()) === null || _a === void 0 ? void 0 : _a.uid);
        },
        navigateToPreviousSection: function () {
            store.navigation.pop();
            if (store.navigation.length >= 1) {
                this.setSectionUid(store.navigation[store.navigation.length - 1]);
            }
        },
        getLastEntry: function () {
            return store.lastEntry;
        },
        setLastEntry: function (entry) {
            store.lastEntry = entry;
            this.persist();
        },
        setEntryDataItem: function (name, value) {
            store.entry[name] = value;
            this.persist();
        },
        setEntryData: function (data) {
            Object.entries(data).forEach(function (pair) { return store.entry[pair[0]] = pair[1]; });
            this.persist();
        },
        getEntryDataItem: function (name) {
            return store.entry[name] || [];
        },
        getEntryData: function () {
            return Object.entries(store.entry);
        },
        getEntryDataAsFormData: function () {
            var formData = new FormData();
            formData.set('survey_uid', store.survey.uid);
            Object.entries(store.entry).forEach(function (pair) {
                pair[1].forEach(function (value) { return formData.append(pair[0], value); });
            });
            return formData;
        },
        getEntry: function () {
            return store.entry;
        },
        resetEntry: function () {
            store.entry = {};
        },
        setScoring: function (scoring) {
            Vue.set(store, 'scoring', scoring);
        },
        startLoading: function (id) {
            if (id === void 0) { id = 'global'; }
            Vue.set(store.loading, id, true);
        },
        stopLoading: function (id) {
            if (id === void 0) { id = 'global'; }
            Vue.set(store.loading, id, false);
        },
        isLoading: function (id) {
            if (id === void 0) { id = 'global'; }
            return Boolean(store.loading[id]);
        },
        persist: function () {
            if (store.survey.preview) {
                return;
            }
            localStorage.setItem("draft:" + store.survey.uid, JSON.stringify({
                entry: store.entry,
                lastEntry: store.lastEntry,
                sectionUid: store.sectionUid,
                navigation: store.navigation
            }));
        },
        restore: function (element) {
            var storedState = JSON.parse(localStorage.getItem("draft:" + store.survey.uid) || '{}');
            store.entry = (storedState === null || storedState === void 0 ? void 0 : storedState.entry) || store.entry;
            store.lastEntry = (storedState === null || storedState === void 0 ? void 0 : storedState.lastEntry) || store.lastEntry;
            store.navigation = (storedState === null || storedState === void 0 ? void 0 : storedState.navigation) || store.navigation;
            store.sectionUid = !this.canRestart() ? 'thankyou' : ((storedState === null || storedState === void 0 ? void 0 : storedState.sectionUid) || store.sectionUid);
            Object.entries(store.entry).forEach(function (pair) {
                var inputs = element.querySelectorAll("[name=\"" + pair[0] + "\"]");
                inputs.forEach(function (input, inputIndex) {
                    var type = input.getAttribute('type');
                    if (type === 'radio' || type === 'checkbox') {
                        input.checked = pair[1].includes(input.value);
                    }
                    else if (type === 'file') {
                    }
                    else {
                        input.value = pair[1][inputIndex] || null;
                    }
                });
            });
        },
        resetNavigation: function () {
            store.navigation = [store.survey.sections[0].uid];
        },
        reset: function (element) {
            this.resetEntry();
            this.dismissErrors();
            element.querySelectorAll('form').forEach(function (form) { return form.reset(); });
            this.resetNavigation();
            localStorage.removeItem("draft:" + store.survey.uid);
            element.parentElement.scrollIntoView({ behavior: "smooth" });
        },
        enableRestart: function () {
            store.survey.canRestart = true;
        },
        disableRestart: function () {
            store.survey.canRestart = false;
        },
        canRestart: function () {
            if (store.survey.hasOwnProperty('canRestart')) {
                return store.survey.canRestart;
            }
            return true;
        },
        validateSection: function (sectionFormData) {
            return __awaiter(this, void 0, void 0, function () {
                return __generator(this, function (_a) {
                    return [2, jQuery
                            .ajax({
                            url: store.config.apiBase + "/survey/section",
                            headers: store.config.nonce ? { 'X-WP-Nonce': store.config.nonce } : {},
                            type: 'post',
                            processData: false,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            data: sectionFormData
                        })
                            .always(function (e) { return e.responseJSON = jQuery.parseJSON(e.responseText); })];
                });
            });
        },
        submitEntry: function (entryFormData) {
            if (entryFormData === void 0) { entryFormData = this.getEntryDataAsFormData(); }
            return __awaiter(this, void 0, void 0, function () {
                return __generator(this, function (_a) {
                    return [2, jQuery
                            .ajax({
                            url: store.config.apiBase + "/entry",
                            headers: store.config.nonce ? { 'X-WP-Nonce': store.config.nonce } : {},
                            type: 'post',
                            processData: false,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            data: entryFormData
                        })
                            .always(function (e) { return e.responseJSON = jQuery.parseJSON(e.responseText); })];
                });
            });
        }
    };
}
function createState(config) {
    var $store = createStateStore(config);
    return {
        $store: $store,
        $actions: createStateActions($store)
    };
}
function serializeFormData(data) {
    var serialized = {};
    data.forEach(function (value, key) {
        if (!Reflect.has(serialized, key)) {
            serialized[key] = value;
            return;
        }
        if (!Array.isArray(serialized[key])) {
            serialized[key] = [serialized[key]];
        }
        serialized[key].push(value);
    });
    return serialized;
}
var Question = {
    name: 'question',
    inject: ['survey', 'section', '$actions'],
    props: {
        uid: { type: String, default: '' },
        index: { type: Number, default: 0 }
    },
    computed: {
        question: function () {
            var _this = this;
            var _a, _b;
            return (_b = (_a = this.section) === null || _a === void 0 ? void 0 : _a.blocks) === null || _b === void 0 ? void 0 : _b.find(function (question) { return question.uid === _this.uid; });
        },
        isRequired: function () {
            var _a, _b, _c;
            return (_c = (_b = (_a = this.question) === null || _a === void 0 ? void 0 : _a.field.validations) === null || _b === void 0 ? void 0 : _b.required) === null || _c === void 0 ? void 0 : _c.enabled;
        },
        error: function () {
            var _a;
            return this.$actions.getFieldError((_a = this.question) === null || _a === void 0 ? void 0 : _a.field.uid);
        }
    }
};
var SectionItem = {
    name: 'section-item',
    inject: ['survey', '$actions', '$store'],
    provide: function () {
        return {
            section: this.section
        };
    },
    props: {
        uid: { type: String, default: '' },
        index: { type: Number, default: 0 },
    },
    computed: {
        section: function () {
            return this.$actions.getSection(this.uid);
        },
        isVisible: function () {
            return this.$actions.isSectionUid(this.uid);
        },
        shouldSubmit: function () {
            return this.$actions.isLastSection();
        },
        scoring: function () {
            return this.$store.scoring;
        },
        canRestart: function () {
            return this.$actions.canRestart();
        },
        lastEntry: function () {
            return this.$actions.getLastEntry();
        }
    },
    components: {
        question: Question
    },
    methods: {
        reload: function () {
            this.$emit('reload', this);
        },
        restart: function () {
            this.$emit('restart', this);
        },
        previous: function () {
            this.$emit('previous', this);
        },
        next: function () {
            this.$emit('next', this);
        },
        submit: function ($event) {
            var formData = new FormData($event.currentTarget);
            formData.set('survey_uid', this.survey.uid);
            formData.set('section_uid', this.uid);
            var data = {};
            formData.forEach(function (value, key) {
                if (!data.hasOwnProperty(key)) {
                    data[key] = [];
                }
                data[key].push(value);
            });
            this.$emit('submit', { data: data, formData: formData });
        },
        input: function ($event) {
            var _a;
            this.$emit('input', {
                name: $event.target.name,
                value: $event.target.type === 'file' ? '' : $event.target.value,
                checked: (_a = $event.target.checked) !== null && _a !== void 0 ? _a : true
            });
        }
    }
};
var Sections = {
    name: 'sections',
    inject: ['survey', 'validateSection', 'submitEntry', '$actions'],
    components: {
        sectionItem: SectionItem,
        question: Question
    },
    methods: {
        reload: function () {
            this.$actions.reset(this.$el);
            location.reload();
        },
        restart: function () {
            this.$actions.reset(this.$el);
            this.$actions.setSectionUid(this.$actions.getFirstSection().uid);
        },
        previous: function () {
            this.$actions.navigateToPreviousSection();
        },
        next: function () {
            this.$actions.navigateToNextSection();
        },
        input: function (_a) {
            var name = _a.name, value = _a.value, _b = _a.checked, checked = _b === void 0 ? true : _b;
            if (name.endsWith('[]')) {
                value = this.$actions.getEntryDataItem(name)
                    .concat([value])
                    .filter(function (item, position, entryDataItem) { return entryDataItem.indexOf(item) == position; })
                    .filter(function (item) { return item !== value || checked; });
            }
            else {
                value = [value];
            }
            this.$actions.setEntryDataItem(name, value);
        },
        validate: function (_a) {
            var _b;
            var data = _a.data, formData = _a.formData;
            return __awaiter(this, void 0, void 0, function () {
                var next, entry;
                return __generator(this, function (_c) {
                    switch (_c.label) {
                        case 0:
                            this.$actions.setEntryData(data);
                            return [4, this.validateSection(formData)];
                        case 1:
                            next = _c.sent();
                            if (!((next === null || next === void 0 ? void 0 : next.action) === 'next' || (next === null || next === void 0 ? void 0 : next.action) === 'section')) return [3, 2];
                            this.$actions.setSectionUid(next.section_uid);
                            return [3, 4];
                        case 2:
                            if (!((next === null || next === void 0 ? void 0 : next.action) === 'submit')) return [3, 4];
                            return [4, this.submitEntry()];
                        case 3:
                            entry = _c.sent();
                            if (entry === null || entry === void 0 ? void 0 : entry.uid) {
                                this.$actions.reset(this.$el);
                                this.$actions.setSectionUid('thankyou');
                                this.survey.canRestart = entry.canRestart;
                                if ((_b = entry === null || entry === void 0 ? void 0 : entry.data) === null || _b === void 0 ? void 0 : _b.scoring) {
                                    this.$actions.setScoring(entry.data.scoring);
                                }
                            }
                            _c.label = 4;
                        case 4: return [2];
                    }
                });
            });
        }
    }
};
var ProgressStatus = {
    name: 'status',
    inject: ['survey', '$actions'],
    computed: {
        progressPercentage: function () {
            if (this.$actions.getSectionIndex() === 0 && this.$actions.getFirstSection().uid === 'welcome') {
                return '0%';
            }
            var currentSectionPosition = this.$actions.getSectionIndex() + 1;
            return Math.ceil((currentSectionPosition / this.survey.sections.length) * 100) + '%';
        },
        isCompleted: function () {
            return this.progressPercentage == '100%';
        }
    }
};
var ErrorMessage = {
    name: 'error-message',
    inject: ['survey', '$actions'],
    computed: {
        error: function () {
            return this.$actions.getGlobalError();
        }
    },
    methods: {
        dismiss: function () {
            this.$actions.dismissGlobalError();
        }
    }
};
var SurveyComponent = {
    name: 'survey',
    components: {
        ErrorMessage: ErrorMessage,
        ProgressStatus: ProgressStatus,
        Sections: Sections,
        SectionItem: SectionItem,
        Question: Question
    },
    props: {
        survey: {
            type: Object,
            default: function () {
                return {};
            }
        },
        nonce: {
            type: String,
            default: null
        },
        apiBase: {
            type: String,
            default: '/wp-json/totalsurvey'
        }
    },
    computed: {
        isLoading: function () {
            return this.$actions.isLoading();
        },
        isFinished: function () {
            return this.$actions.isFinished();
        },
    },
    data: function () {
        if (this.survey.settings.contents.welcome.enabled) {
            this.survey.sections.unshift({ 'uid': 'welcome' });
        }
        this.survey.sections.push({ 'uid': 'thankyou' });
        var data = createState({ survey: this.survey, nonce: this.nonce, apiBase: this.apiBase });
        this.$actions = data.$actions;
        this.$store = data.$store;
        return {};
    },
    provide: function () {
        return {
            survey: this.survey,
            lastEntry: this.$store.lastEntry,
            validateSection: this.validateSection,
            submitEntry: this.submitEntry,
            $store: this.$store,
            $actions: this.$actions
        };
    },
    mounted: function () {
        this.$actions.restore(this.$el);
    },
    methods: {
        validateSection: function (formData) {
            var _a;
            return __awaiter(this, void 0, void 0, function () {
                var response, e_1;
                var _this = this;
                return __generator(this, function (_b) {
                    switch (_b.label) {
                        case 0:
                            if (this.survey.preview) {
                                return [2, { action: 'next', section_uid: this.$actions.getNextSection().uid }];
                            }
                            this.$actions.dismissErrors();
                            _b.label = 1;
                        case 1:
                            _b.trys.push([1, 3, , 4]);
                            this.$actions.startLoading();
                            return [4, this.$actions.validateSection(formData)];
                        case 2:
                            response = _b.sent();
                            this.$actions.stopLoading();
                            if (response.success) {
                                this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                                return [2, response.data];
                            }
                            else {
                                throw new Error(response.error);
                            }
                            return [3, 4];
                        case 3:
                            e_1 = _b.sent();
                            this.$actions.stopLoading();
                            this.$actions.setGlobalError(((_a = e_1.responseJSON) === null || _a === void 0 ? void 0 : _a.error) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.message) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.statusText) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.responseText));
                            Object.entries(e_1.responseJSON.data).forEach(function (pair) { var _a; return _this.$actions.setFieldError(pair[0], (_a = pair[1]) === null || _a === void 0 ? void 0 : _a.join("\n")); });
                            this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                            return [2, false];
                        case 4: return [2];
                    }
                });
            });
        },
        submitEntry: function () {
            var _a;
            return __awaiter(this, void 0, void 0, function () {
                var response, e_2;
                var _this = this;
                return __generator(this, function (_b) {
                    switch (_b.label) {
                        case 0:
                            if (this.survey.preview) {
                                return [2];
                            }
                            this.$actions.dismissErrors();
                            _b.label = 1;
                        case 1:
                            _b.trys.push([1, 3, , 4]);
                            this.$actions.startLoading();
                            return [4, this.$actions.submitEntry()];
                        case 2:
                            response = _b.sent();
                            this.$actions.stopLoading();
                            if (response.success) {
                                this.$actions.setLastEntry(response.data);
                                this.$root.$emit('submit', {});
                                return [2, response.data];
                            }
                            else {
                                throw new Error(response.error);
                            }
                            return [3, 4];
                        case 3:
                            e_2 = _b.sent();
                            this.$actions.stopLoading();
                            this.$actions.setGlobalError(((_a = e_2.responseJSON) === null || _a === void 0 ? void 0 : _a.error) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.message) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.statusText) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.responseText));
                            Object.entries(e_2.responseJSON.data).forEach(function (pair) { var _a; return _this.$actions.setFieldError(pair[0], (_a = pair[1]) === null || _a === void 0 ? void 0 : _a.join("\n")); });
                            this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                            return [2, false];
                        case 4: return [2];
                    }
                });
            });
        }
    }
};
Vue.directive('other', {
    bind: function (el) {
        jQuery('input[type="text"]', el).on('input', function () {
            jQuery('input.other', el).val(jQuery(this).val());
        });
        jQuery('input.other', el).on('change', function () {
            jQuery('input[type="text"]', el).val(jQuery(this).val());
        });
    }
});
document.querySelectorAll('.totalsurvey-wrapper').forEach(function (wrapperElement) {
    var template = wrapperElement.querySelector('template');
    var host = document.createElement('div');
    host.classList.add('totalsurvey-survey');
    host.attachShadow({ mode: 'open' }).append(template.content);
    template.after(host);
    host.shadowRoot.querySelectorAll('survey-style, survey-link, survey-script').forEach(function (el) {
        var style = document.createElement(el.tagName.toLowerCase().replace('survey-', ''));
        style.textContent = el.textContent;
        el.getAttributeNames().forEach(function (name) { return style.setAttribute(name, el.getAttribute(name)); });
        el.after(style);
        el.remove();
    });
    new Vue({
        el: host.shadowRoot.querySelector('#survey'),
        components: {
            survey: SurveyComponent
        },
        mounted: function () {
            host.shadowRoot.instance = this;
        }
    });
    template.remove();
});
//# sourceMappingURL=app.js.map