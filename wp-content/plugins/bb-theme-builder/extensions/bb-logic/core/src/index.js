import {
	addRuleTypeCategory,
	addRuleType,
	removeRuleType,
	removeRuleTypesByCategory,
	getFormPreset,
	getPermalinks
} from './api'
import { __ } from './i18n'
import RuleForm from './components/rule-form'
import './style.scss'

window.BBLogic = {
	api: {
		addRuleTypeCategory,
		addRuleType,
		removeRuleType,
		removeRuleTypesByCategory,
		getFormPreset,
		getPermalinks,
	},
	components: {
		RuleForm,
	},
	i18n: {
		__,
	},
	request: {
		root: '',
		headers: {},
	},
}
