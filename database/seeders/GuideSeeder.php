<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@bg3guide.com')->first();
        if (!$admin) return;

        $guides = [
            [
                'category' => 'quests',
                'title'   => 'Completing the Goblin Camp: Full Walkthrough',
                'content' => "The Goblin Camp is one of the most pivotal locations in Act 1 of Baldur's Gate 3.\n\nGetting In\nYou can enter the camp through several routes: through the main gate using a disguise, through the Underdark entrance, or by fighting your way through.\n\nKey Objectives\n- Rescue the Druid Halsin from the Worg Pens\n- Deal with the three goblin leaders: Minthara, Dror Razglin, and Priestess Gut\n- Free the prisoners from the camp\n\nTips\nIf you want to keep things non-violent, use the Deception and Persuasion checks available throughout the camp. High Charisma characters can navigate most of the camp without a fight.\n\nRecommended Party\nA balanced party with at least one high-Charisma character and a Cleric for undead encounters inside the temple.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Rescue the Druid Halsin: Grove Quest Guide',
                'content' => "The first major questline in Baldur's Gate 3 pushes you toward the Goblin Camp, but the true goal is to rescue Halsin and calm the conflict at the Emerald Grove.\n\nMain Steps\n1. Speak to Zevlor and the druids to understand both sides of the conflict\n2. Track the goblin leaders inside the camp\n3. Free Halsin from the Worg Pens\n4. Return to the Grove and report what happened\n\nHelpful Tips\n- Bring one character with good Persuasion or Deception\n- Save before approaching the goblin leaders so you can try multiple solutions\n- If you start a fight, use terrain and choke points to control the enemies\n\nReward Path\nFinishing this quest opens up new companion dialogue, reinforces your act 1 story path, and sets up several later decisions in the campaign.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Save Mayrina: The Auntie Ethel Quest Walkthrough',
                'content' => "The Hag's Lair quest is one of the creepiest early missions in Baldur's Gate 3. Auntie Ethel lures you into a trap, and every choice you make changes how the encounter plays out.\n\nMain Steps\n1. Follow the clues to Ethel's teahouse and descend into the swamp\n2. Explore the hidden lair and locate Mayrina\n3. Deal with Ethel's illusions, traps, and masked servants\n4. Confront the hag and decide whether to save or bargain for Mayrina\n\nHelpful Tips\n- Use See Invisibility or similar effects if you have them\n- Fire damage and area control spells are strong against the hag's minions\n- Check every corner of the lair for hidden passages and alternative routes\n\nReward Path\nYou can earn useful loot and unique story outcomes depending on whether you fight Ethel directly or manipulate the encounter.",
            ],
            [
                'category' => 'quests',
                'title'   => 'The Githyanki Creche: Mountain Pass Quest Route',
                'content' => "This quest sends you toward the Mountain Pass and the Githyanki Creche, where the story shifts from goblins and druids to Lae'zel's personal conflict.\n\nMain Steps\n1. Follow Lae'zel's lead and travel toward the Mountain Pass\n2. Enter the creche and speak to the githyanki patrols carefully\n3. Decide how far you want to push the truth about the artefact\n4. Investigate the machine and the secrets beneath the creche\n\nHelpful Tips\n- Keep your dialogue choices calm if you want to avoid an early fight\n- Prepare for psychic and martial enemies with strong burst damage\n- Bring healing and mobility spells before entering the deeper chambers\n\nReward Path\nThis quest can change Lae'zel's outlook, unlock major story choices, and lead into one of the most important act transitions in the game.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Break the Shadow Curse: Halsin’s Act 2 Quest',
                'content' => "Act 2 shifts the story into the Shadow-Cursed Lands, and Halsin's questline is one of the most important tasks if you want to fully restore the region.

Main Steps
1. Reach Last Light Inn and speak with the key NPCs there
2. Follow the trail that leads toward Thaniel and the shadow curse
3. Protect the portal while Halsin searches for the missing soul fragment
4. Explore the deeper cursed areas and solve the healing of the land

Helpful Tips
- Bring radiance, daylight, and healing tools to handle the curse
- Keep a strong front line because many enemies hit hard in close range
- Travel with a balanced party so you can survive the long act 2 encounters

Reward Path
This quest opens major act 2 progress, strengthens Halsin's story, and helps move the whole region toward recovery.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Find Ketheric’s Weakness: Moonrise Towers Infiltration',
                'content' => "Moonrise Towers is the central location of Act 2, and learning how to navigate it can change the way the entire chapter plays out.

Main Steps
1. Gather information from the cultists and prisoners around Moonrise Towers
2. Explore the lower floors, docks, and hidden routes carefully
3. Decide whether to rescue captives first or push deeper into the tower
4. Prepare for the confrontation that leads into the Ketheric Thorm storyline

Helpful Tips
- Use stealth if you want to avoid triggering too many fights early
- Keep persuasion options open with the right dialogue choices
- Explore every room before moving on, because the tower has several important clues

Reward Path
This quest sets up the act 2 climax and gives you critical story context before the final assault.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Steel Watch Shutdown: Gortash’s City Quest',
                'content' => "Once you reach Baldur's Gate in Act 3, the Steel Watch becomes one of the biggest threats in the city, and shutting it down changes the entire balance of power.

Main Steps
1. Investigate the Steel Watch Foundry and the surrounding city politics
2. Track the clues that lead to the control system behind the machines
3. Disable the foundry’s power source and weaken Gortash’s reach
4. Return to the city with the Steel Watch removed as a threat

Helpful Tips
- Expect traps, machinery, and heavy enemy resistance
- Keep a few mobility spells ready for the foundry's vertical spaces
- Try to save your strongest damage for the most dangerous constructs

Reward Path
Disabling the Steel Watch opens up more freedom in the city and makes later Act 3 fights much more manageable.",
            ],
            [
                'category' => 'quests',
                'title'   => 'Confront the Elder Brain: Final Act 3 Quest Guide',
                'content' => "The endgame of Baldur's Gate 3 brings every major story thread together, and the final confrontation with the Elder Brain is the culmination of everything you've done.

Main Steps
1. Gather your allies and finish the major companion quests
2. Make the final choice about how to approach the Netherstone conflict
3. Push through the last defenses around the Brain's chamber
4. Decide the ending path for your character and the city

Helpful Tips
- Rest and prepare before entering the endgame so you start at full strength
- Bring consumables, scrolls, and emergency healing for the last fights
- Review companion decisions before you lock in your ending route

Reward Path
This quest decides the final outcome of the campaign and wraps up the entire story arc.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Sorcadin: Sorcerer/Paladin Multiclass Build Guide',
                'content' => "The Sorcadin is widely considered one of the most powerful builds in BG3, combining the Paladin's burst damage with the Sorcerer's spell slots and metamagic.\n\nCore Setup\n- Paladin 5 / Sorcerer 7 (Oath of the Ancients + Storm Sorcerer)\n\nKey Abilities\n- Divine Smite: Burn spell slots for massive bonus radiant damage on hits\n- Quickened Spell: Use a bonus action to cast a spell normally requiring an action\n- Extra Attack (Paladin 5): Attack twice per turn\n\nFeat Priority\n1. Polearm Master or War Caster\n2. Ability Score Improvement (CHA to 20)\n\nPlaystyle\nOpen combat by casting Haste (Quickened from Sorcerer). Then on your turn, attack twice and Smite with a high-level slot on the second hit. You will end most encounters in 1-2 rounds.",
            ],
            [
                'category' => 'strategies',
                'title'   => 'How to Beat the Adamantine Forge Boss',
                'content' => "The Grym fight at the Adamantine Forge is one of the most memorable boss encounters in Act 1.\n\nThe Mechanic\nGrym is almost invulnerable to conventional damage. You must use the Forge's lava vents and the central lava pool:\n1. Lure Grym onto the central platform\n2. Activate a lava vent to submerge it in lava (heating it up)\n3. Strike with the Forge Hammer while Grym is superheated\n\nPractical Steps\n- Split your party: one character operates the vents, another the hammer lever\n- Use movement abilities (Misty Step, Dash) to stay out of Grym's stomp range\n- A single hammer strike on a superheated Grym deals 60-100+ damage\n\nYou only need to use the hammer twice to defeat it on most difficulties.",
            ],
            [
                'category' => 'gameplay-tips',
                'title'   => 'Essential Tips Every BG3 Player Should Know',
                'content' => "Whether you're new to Baldur's Gate 3 or returning for another playthrough, these tips will save you time and frustration.\n\n1. Save Often\nUse the F5 quicksave constantly. The game's RPG systems mean you'll want to try different approaches.\n\n2. Shove is Incredibly Powerful\nShoving enemies off ledges is often the fastest way to deal with tough enemies. It's a bonus action, so you can still attack.\n\n3. Use the High Ground\nControl the high ground in combat for Advantage on ranged attacks. Position before the fight starts.\n\n4. Talk to Your Camp Companions\nCompanion approval unlocks powerful buffs and unique storylines. Rest regularly and speak to everyone.\n\n5. Examine Everything\nRight-click and examine enemies to learn their vulnerabilities. Switching damage types (fire vs cold) often makes a huge difference.\n\n6. Ritual Spells are Free\nSpells marked as 'Ritual' can be cast outside of combat without using a spell slot. Use Speak with Animals freely.\n\n7. Jump and Disengage\nYou can jump as a bonus action to avoid opportunity attacks. This is often better than the Disengage action.",
            ],
        ];

        foreach ($guides as $data) {
            $category = Category::where('slug', $data['category'])->first();
            if (!$category) continue;

            Guide::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title'       => $data['title'],
                    'content'     => $data['content'],
                    'category_id' => $category->id,
                    'user_id'     => $admin->id,
                    'status'      => 'published',
                ]
            );
        }
    }
}
