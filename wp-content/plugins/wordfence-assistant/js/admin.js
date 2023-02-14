if(! window['wordfenceAst']){ //To compile for checking: java -jar /usr/local/bin/closure.jar --js=admin.js --js_output_file=test.js
window['wordfenceAst'] = {
	loadingCount: 0,
	nonce: '',
	init: function(){
		this.nonce = WordfenceAstVars.firstNonce; 
		jQuery('.wf-assistant-checkbox').each(function() {
			var checkbox = jQuery(this).find('input[type=checkbox]');
			jQuery(this).find('label').on('click', function() {
				checkbox.trigger('click');
			});
		});
	},
	delAll: function(){
		var delete2faSecrets = jQuery('#delete_2fa_secrets').prop('checked');
		var message;
		if (delete2faSecrets) {
			message = "Are you sure you want to delete all Wordfence data and tables, including 2FA secrets?";
		}
		else {
			message = "Are you sure you want to delete all Wordfence data and tables except for 2FA secrets?";
		}
		if(confirm(message)){
			this.ajax({ func: 'delAll', delete2faSecrets: delete2faSecrets });
		}
	},
	clearLocks: function(){
		if(confirm("Are you sure you want to clear all locked IP addresses, users and any advanced locks you have?")){
			this.ajax({ func: 'clearLocks' });
		}
	},
	clearLiveTraffic: function(){
		if(confirm("Are you sure you want to delete all Live Traffic Data for Wordfence?")){
			this.ajax({ func: 'clearLiveTraffic' });
		}
	},
	disableFirewall: function(){
		if(confirm("Are you sure you want to disable the Wordfence firewall?")){
			this.ajax({ func: 'disableFirewall' }, function(json) {
				if (json.html) {
					jQuery('#disableFirewall').html(json.html);
				}
			});
		}
	},
	finalizeDisableFirewall: function() {
		this.ajax({ func: 'finalizeDisableFirewall' }, function() {
			jQuery('#disableFirewall').html('');
		});
	},
	disableBlacklist: function() {
		if(confirm("Are you sure you want to disable the Wordfence IP Blocklist?")){
			this.ajax({ func: 'disableIPBlacklist' });
		}
	},
	disableAutoUpdate: function() {
		if(confirm("Are you sure you want to disable Wordfence automatic updates?")){
			this.ajax({ func: 'disableAutoUpdate' });
		}
	},
	ajax: function(data, callback){
		if(typeof(data) == 'string'){
			if(data.length > 0){
				data += '&';
			}
			data += 'action=wordfenceAssistant_do&nonce=' + this.nonce;
		} else if(typeof(data) == 'object'){
			data['action'] = 'wordfenceAssistant_do';
			data['nonce'] = this.nonce;
		}
		var self = this;
		this.showLoading();
		jQuery.ajax({
			type: 'POST',
			url: WordfenceAstVars.ajaxURL,
			dataType: "json",
			data: data,
			success: function(json){ 
				self.removeLoading();
				if(json && json.nonce){
					self.nonce = json.nonce;
				}
				if(json && json.errorMsg){
					alert('An error occurred: ' + json.errorMsg);
				}
				if(json.msg){
					alert(json.msg);
				}
				typeof callback === 'function' && callback(json);
			},
			error: function(){ 
				self.removeLoading();  
			}
			});
	},
	showLoading: function(){
		this.loadingCount++;
		if(this.loadingCount == 1){
			jQuery('<div id="wordfenceAstWorking">Wordfence Assistant is working...</div>').appendTo('body');
		}
	},
	removeLoading: function(){
		this.loadingCount--;
		if(this.loadingCount == 0){
			jQuery('#wordfenceAstWorking').remove();
		}
	}
};
window['WFAST'] = window['wordfenceAst'];
}
jQuery(function(){
	wordfenceAst.init();
});
