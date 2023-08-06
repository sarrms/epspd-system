<style>
	.main {
		font-family: "Bahnschrift", sans-serif;
		width: 1220px;
		position: relative;
		margin: auto;
		margin-top: 60px;
	}
	@media screen and (min-width: 1268.67px) and (max-width: 1522.39px) {
		.main:has(.maximized) {
			width: calc(100% - 320px);
			margin-left: 310px;
		}
		.main .maximized ~ .main-body .application-evaluation-table tr:first-child th {
			text-align: left;
		}
		.main:has(.minimized) {
			width: calc(100% - 90px);
			margin-left: 80px;
		}
	}
	@media screen and (min-width: 1522.40px) and (max-width: 1902.99px) {
		.main:has(.maximized) {
			width: calc(100% - 320px);
			margin-left: 310px;
		}
		.main:has(.minimized) {
			width: 1220px;
			margin: auto;
			margin-top: 60px;
		}
	}
	@media screen and (min-width: 1903px) {
		.main {
			margin: none;
		}
	}
</style>