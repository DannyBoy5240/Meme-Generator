const { addRuleTypeCategory } = BBLogic.api
const { __ } = BBLogic.i18n

addRuleTypeCategory( 'post', {
	label: __( 'Post' )
} )

import './post'
import './post-parent'
import './post-type'
import './post-title'
import './post-excerpt'
import './post-content'
import './post-featured-image'
import './post-comments-number'
import './post-comments-status'
import './post-template'
import './post-term'
import './post-status'
import './post-meta'

addRuleTypeCategory( 'archive', {
	label: __( 'Archive' )
} )

import './archive'
import './archive-title'
import './archive-description'
import './archive-term'
import './archive-term-meta'

addRuleTypeCategory( 'author', {
	label: __( 'Author' )
} )

import './author'
import './author-bio'
import './author-meta'
import './author-role'
import './author-login-status'

addRuleTypeCategory( 'user', {
	label: __( 'User' )
} )

import './user'
import './user-bio'
import './user-meta'
import './user-login-status'
import './user-role'
import './user-capability'
import './user-registered'

addRuleTypeCategory( 'conditional-tag', {
	label: __( 'WordPress Conditionals' )
} )

import './conditional-tag.js'
import './shortcode'
