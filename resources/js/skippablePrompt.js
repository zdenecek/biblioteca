if (!alertify.skippablePrompt) {
    alertify.dialog('skippablePrompt', function factory() {
        var label = document.createElement('label')
        var input = document.createElement('input');
        var p = document.createElement('p');
        return {

            main: function ({
                    title, message, label,
                    onOk = () => { },
                    onSkip = () => { },
                    onCancel = () => { }
                } = {}
                ) {
                this.set('title', title);
                this.set('label', label);
                this.set('message', message);
                this.set('callbacks', {
                    cancel: onCancel,
                    skip: onSkip,
                    ok: onOk
                })
                return this
            },
            setup: function () {
                return {
                    buttons: [
                        {
                            text: 'Zrušit',
                            invokeOnClose: true,
                            className: 'btn-a btn-a-gray',
                            callback: 'cancel'
                        },
                        {
                            text: 'Přeskočit',
                            className: 'btn-a btn-a-red',
                            callback: 'skip'
                        },
                        {
                            text: 'OK',
                            className: 'btn-a btn-a-blue',
                            callback: 'ok'
                        }
                    ],
                    focus: {
                        element: input,
                        select: true
                    },
                    options: {
                        maximizable: false,
                        resizable: false
                    }
                };
            },
            settings: {
                message: undefined,
                label: undefined,
                callbacks: {},
            },
            build: function () {
                input.className = 'input'
                input.id = "_prompt-input"
                input.setAttribute('type', 'text');
                label.for = "_prompt-input"
                label.className = "label mt-4"
                p.className = "text-gray-800 text-md text-justify"
                this.elements.content.appendChild(p);
                this.elements.content.appendChild(label);
                this.elements.content.appendChild(input);

            },
            callback: function (closeEvent) {
                this.get('callbacks')[closeEvent.button.callback].call(this, input.value)
            },
            prepare: function()
            {
                label.innerHTML = this.get('label')
                p.innerHTML = this.get('message')
            }
        }
    });
}
