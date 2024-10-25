<script lang="ts">
	import type { PageData } from './$types';
	import MetaGroups from '$lib/components/MetaGroups.svelte';
	import { CheckBadge, Sparkles } from '@steeze-ui/heroicons';
	import { Icon } from '@steeze-ui/svelte-icon';
	import ArticlePreview from '$lib/components/post/ArticlePreview.svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';
	import { getContext } from 'svelte';
	import { localePath } from '$lib/translations';
	import ColorLayout from '$lib/components/static_pages/ColorLayout.svelte';
	import Hero from '$lib/components/content/Hero.svelte';
	import FeaturedCategories from '$lib/components/content/FeaturedCategories.svelte';
	import { user } from '$lib/stores/auth';

	import LoginLink from '$lib/components/nav/LoginLink.svelte';
	import RegisterButton from '$lib/components/atoms/buttons/RegisterButton.svelte';
	import FooterMain from '$lib/components/footer/FooterMain.svelte';

	const t = getContext('t');
	const locale = getContext('locale');
	export let data: PageData;

	let featuredCategories = [
		{ name: 'trending', works: [...data.trendingWorks], href: '/tag/all/trending' },
		{ name: 'rising', works: [...data.newAndRisingWorks], href: '/tag/all/rising' }
	];
</script>

<MetaGroups
	title={$t('global.seo.title.index')}
	description={$t('global.seo.description.index')}
	image="https://i.arts.center/logo_white.png"
	rss={localePath($locale, '/feed/rss/featured')}
	atom={localePath($locale, '/feed/atom/featured')}
/>

<main>
	<Hero />
	<FeaturedCategories {featuredCategories} />

	<!-- Join Us -->

	{#if !$user}
		<ColorLayout details="bg-zinc-900 dark:border-t-transparent text-white xs:py-12">
			<section class="container tracking-widest mx-auto space-y-6 px-3 md:flex items-center gap-16">
				<div class="space-y-3 font-light">
					<h2 class="text-3xl">{$t(`global.main_page.join.h`)}</h2>

					<p class="sm:text-lg">
						{$t(`global.main_page.join.p`)}
					</p>
					<p class="text-xs lg:pr-12">
						**{$t(`global.main_page.join.note1`)} <br />
						**{$t(`global.main_page.join.note2`)}
					</p>
				</div>

				<div
					class=" flex justify-center gap-6 md:gap-9 sm:max-md:flex-row max-xl:flex-col flex-col lg:w-2/5"
				>
					<LoginLink
						styles="py-3 px-6 tracking-widest lg:text-lg  border-zinc-300 bg-zinc-800 text-white w-full hover:bg-zinc-700"
					/>
					<RegisterButton
						styles="tracking-widest lg:text-lg w-full  px-6 py-3  border-zinc-300 bg-zinc-800 dark:border-zinc-500 "
					/>
				</div>
			</section>
		</ColorLayout>
	{/if}

	<section class="container mx-auto px-3">
		<div class="flex xl:flex-row flex-col max-xs:mx-1 xl:divide-x dark:divide-zinc-800">
			<!------- Blogs ------>
			<div class="xl:w-3/4 divide-y dark:divide-zinc-700 xl:pr-16 pb-16 {$user ? '' : ' pt-16'}">
				<div class="  dark:border-zinc-800 flex items-center gap-3 {$user ? 'py-6' : '  pb-6'}">
					<h2 class=" text-2xl font-medium">{$t('global.main_page.featured_posts')}</h2>
					<Icon src={Sparkles} theme="solid" class="w-7 h-7 text-amber-500 stroke-1" />
				</div>

				<div class=" divide-y dark:divide-zinc-800">
					{#each data.posts as post (post.id)}
						<ArticlePreview {post} withAuthor />
					{/each}
				</div>
			</div>

			<div class="xl:w-1/3 space-y-16 xl:pl-16 pb-16 {$user ? '' : ' pt-16'}">
				<!------- Last verified artists ------>
				<div>
					<div
						class="border-b dark:border-zinc-800 flex items-center gap-3 pb-6 {$user ? 'pt-6' : ''}"
					>
						<h2 class=" text-2xl font-medium">
							{$t('global.main_page.last_verified')}
						</h2>

						<Icon src={CheckBadge} theme="solid" class="w-7 h-7 text-emerald-500 stroke-1" />
					</div>

					<div class="space-y-6 mt-6">
						{#each data.users as user (user.id)}
							<div class="flex items-center justify-between gap-6 xl:text-sm">
								<AvatarLink {user} withName size={'w-8 h-8 '} nameStyles="font-medium" />

								<div class="flex justify-end w-28">
									<FollowButton
										addStyles={'text-xs max-sm:text-xs xl:text-xs   border border border-zinc-500 border-zinc-800 text-zinc-800 dark:bg-zinc-800  w-min px-3 py-1 text-center'}
										{user}
									/>
								</div>
							</div>
						{/each}
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<FooterMain />
