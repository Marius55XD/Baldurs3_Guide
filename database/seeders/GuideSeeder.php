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

        $guideMetaByTitle = [
            'Completing the Goblin Camp: Full Walkthrough' => [
                'featured_image' => 'images/guides/guide_1_1775920868.jpg',
                'views' => 3,
            ],
            'Sorcadin: Sorcerer/Paladin Multiclass Build Guide' => [
                'featured_image' => 'images/guides/guide_2_1775863362.jpg',
                'views' => 0,
            ],
            'How to Beat the Adamantine Forge Boss' => [
                'featured_image' => 'images/guides/guide_3_1775863417.gif',
                'views' => 0,
            ],
            'Essential Tips Every BG3 Player Should Know' => [
                'featured_image' => 'images/guides/guide_4_1775921307.jpg',
                'views' => 2,
            ],
            'Rescue the Druid Halsin: Grove Quest Guide' => [
                'featured_image' => 'images/guides/guide_5_1775920841.jpg',
                'views' => 7,
            ],
            'Save Mayrina: The Auntie Ethel Quest Walkthrough' => [
                'featured_image' => 'images/guides/guide_6_1775920925.jpg',
                'views' => 2,
            ],
            'The Githyanki Creche: Mountain Pass Quest Route' => [
                'featured_image' => 'images/guides/guide_7_1775921025.jpg',
                'views' => 1,
            ],
            'Break the Shadow Curse: Halsin’s Act 2 Quest' => [
                'featured_image' => 'images/guides/guide_8_1775921101.jpg',
                'views' => 1,
            ],
            'Find Ketheric’s Weakness: Moonrise Towers Infiltration' => [
                'featured_image' => 'images/guides/guide_9_1775921144.jpg',
                'views' => 1,
            ],
            'Steel Watch Shutdown: Gortash’s City Quest' => [
                'featured_image' => 'images/guides/guide_10_1775921200.jpg',
                'views' => 1,
            ],
            'Confront the Elder Brain: Final Act 3 Quest Guide' => [
                'featured_image' => 'images/guides/guide_11_1775921244.jpg',
                'views' => 2,
            ],
        ];

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
                'category' => 'character-builds',
                'title'   => 'Lockadin: Paladin/Warlock Multiclass Build Guide',
                'content' => "Lockadin combines Paladin burst with Warlock short-rest spell slots, creating a very consistent smite machine from early game through level 12.\n\nCore Setup\n- Paladin 7 / Warlock 5\n- Oath of Vengeance + The Fiend (or Great Old One)\n- Key stats: CHA highest, then STR and CON\n\nLevel Progression (1-12)\n1. Paladin 1: Heavy armor, Lay on Hands\n2. Paladin 2: Fighting Style and Divine Smite\n3. Paladin 3: Oath of Vengeance and Vow of Enmity\n4. Paladin 4: Feat - +2 CHA\n5. Paladin 5: Extra Attack\n6. Warlock 1: Eldritch Blast and Hex\n7. Warlock 2: Invocations (Agonizing Blast + Devil's Sight)\n8. Warlock 3: Pact of the Blade\n9. Warlock 4: Feat - +2 CHA (to 20)\n10. Warlock 5: Access to stronger pact slots for frequent smites\n11. Paladin 6: Aura of Protection\n12. Paladin 7: Oath feature upgrade\n\nGameplay Loop\nUse Vow of Enmity on priority targets, attack in melee with pact weapon, and dump warlock spell slots into Divine Smite. On turns where enemies are far away, use Eldritch Blast with Agonizing Blast for ranged pressure.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Evocation Wizard Level 1-12 Build Guide',
                'content' => "This build focuses on safe, high-damage AoE casting and strong late-game control. Evocation is perfect for players who want reliable spell damage without friendly-fire problems.\n\nCore Setup\n- Class: Wizard (Evocation)\n- Background: Sage or Charlatan\n- Key stats: INT highest, then DEX and CON\n\nLevel Progression (1-12)\n1. Wizard 1: Learn Magic Missile, Shield, and Sleep for early control\n2. Wizard 2: Choose Evocation for Sculpt Spells\n3. Wizard 3: Add Misty Step and Scorching Ray\n4. Wizard 4: Feat - Ability Score Improvement (+2 INT)\n5. Wizard 5: Unlock Fireball and Counterspell\n6. Wizard 6: Potent Cantrip improves reliable damage\n7. Wizard 7: Add Wall of Fire or Banishment\n8. Wizard 8: Feat - Alert or +2 INT (to 20)\n9. Wizard 9: Learn Cone of Cold\n10. Wizard 10: Empowered Evocation boosts spell damage\n11. Wizard 11: Chain Lightning or Globe of Invulnerability\n12. Wizard 12: Feat - War Caster or Resilient (CON)\n\nGameplay Loop\nStart fights from high ground, open with control, then drop Fireball or Chain Lightning on grouped enemies while Sculpt Spells protects allies.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Draconic Sorcerer Level 1-12 Build Guide',
                'content' => "A pure Sorcerer build with strong burst, high mobility, and metamagic flexibility. Draconic Bloodline improves survivability while keeping top-tier spell damage.\n\nCore Setup\n- Class: Sorcerer (Draconic Bloodline)\n- Key stats: CHA highest, then DEX and CON\n\nLevel Progression (1-12)\n1. Sorcerer 1: Pick Chromatic Orb and Shield\n2. Sorcerer 2: Gain Font of Magic\n3. Sorcerer 3: Choose Quickened Spell and Twinned Spell\n4. Sorcerer 4: Feat - Ability Score Improvement (+2 CHA)\n5. Sorcerer 5: Learn Fireball and Haste\n6. Sorcerer 6: Elemental Affinity boosts chosen damage type\n7. Sorcerer 7: Add Greater Invisibility or Dimension Door\n8. Sorcerer 8: Feat - +2 CHA (to 20)\n9. Sorcerer 9: Learn Hold Monster or Cone of Cold\n10. Sorcerer 10: Add Heightened Spell for save-or-lose spells\n11. Sorcerer 11: Chain Lightning or Disintegrate\n12. Sorcerer 12: Feat - Alert or War Caster\n\nGameplay Loop\nOpen with Haste or control, then use Quickened Spell to cast and reposition in one turn. Save sorcery points for key burst turns against bosses.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Oath of Vengeance Paladin Level 1-12 Build Guide',
                'content' => "A frontline holy striker that excels at deleting priority targets with Divine Smite. This build is easy to pilot and strong in every act.\n\nCore Setup\n- Class: Paladin (Oath of Vengeance)\n- Key stats: STR highest, then CHA and CON\n\nLevel Progression (1-12)\n1. Paladin 1: Heavy armor and Lay on Hands\n2. Paladin 2: Fighting Style (Great Weapon Fighting) and Divine Smite\n3. Paladin 3: Oath of Vengeance and Vow of Enmity\n4. Paladin 4: Feat - Great Weapon Master\n5. Paladin 5: Extra Attack\n6. Paladin 6: Aura of Protection\n7. Paladin 7: Relentless Avenger for stickiness\n8. Paladin 8: Feat - +2 STR (or +2 CHA)\n9. Paladin 9: Access to level 3 spells\n10. Paladin 10: Aura of Courage\n11. Paladin 11: Improved Divine Smite\n12. Paladin 12: Feat - Sentinel or +2 STR\n\nGameplay Loop\nUse Vow of Enmity on dangerous enemies, attack twice, and spend spell slots on crits for massive burst damage. Stay near allies to share aura bonuses.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Battle Master Fighter Level 1-12 Build Guide',
                'content' => "Battle Master is a consistent martial powerhouse with strong control through maneuvers and excellent action economy.\n\nCore Setup\n- Class: Fighter (Battle Master)\n- Key stats: STR highest, then CON and DEX\n\nLevel Progression (1-12)\n1. Fighter 1: Fighting Style and Second Wind\n2. Fighter 2: Action Surge\n3. Fighter 3: Choose Battle Master maneuvers (Trip Attack, Precision Attack, Riposte)\n4. Fighter 4: Feat - Great Weapon Master\n5. Fighter 5: Extra Attack\n6. Fighter 6: Feat - +2 STR\n7. Fighter 7: More maneuvers and superiority dice\n8. Fighter 8: Feat - Alert or Polearm Master\n9. Fighter 9: Indomitable\n10. Fighter 10: Improved combat superiority\n11. Fighter 11: Extra Attack (2)\n12. Fighter 12: Feat - Sentinel or +2 STR\n\nGameplay Loop\nControl enemies with Trip Attack, then unload multi-attacks and Action Surge during advantage windows. Prioritize high-threat casters and archers.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Gloom Stalker Ranger Level 1-12 Build Guide',
                'content' => "This stealth-focused ranged build shines in ambushes and opening rounds, with excellent initiative and first-turn burst.\n\nCore Setup\n- Class: Ranger (Gloom Stalker)\n- Key stats: DEX highest, then WIS and CON\n\nLevel Progression (1-12)\n1. Ranger 1: Choose favored enemy and natural explorer options\n2. Ranger 2: Archery Fighting Style and Hunter's Mark\n3. Ranger 3: Gloom Stalker and Dread Ambusher\n4. Ranger 4: Feat - Sharpshooter\n5. Ranger 5: Extra Attack and level 2 spells\n6. Ranger 6: Improved exploration passives\n7. Ranger 7: Iron Mind\n8. Ranger 8: Feat - +2 DEX\n9. Ranger 9: Access to level 3 ranger spells\n10. Ranger 10: Hide in Plain Sight style utility\n11. Ranger 11: Stalker's Flurry\n12. Ranger 12: Feat - Alert or Crossbow Expert\n\nGameplay Loop\nStart from stealth whenever possible. Use opening-round bonus attack from Dread Ambusher and focus down key targets before they act.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Life Cleric Level 1-12 Build Guide',
                'content' => "Life Cleric is the safest party backbone for Honour Mode and difficult fights, with powerful healing and strong utility.\n\nCore Setup\n- Class: Cleric (Life Domain)\n- Key stats: WIS highest, then CON and DEX\n\nLevel Progression (1-12)\n1. Cleric 1: Heavy armor, Bless, and Healing Word\n2. Cleric 2: Channel Divinity (Preserve Life)\n3. Cleric 3: Access to level 2 support spells\n4. Cleric 4: Feat - War Caster\n5. Cleric 5: Spirit Guardians and Revivify\n6. Cleric 6: Improved healing features\n7. Cleric 7: Access to level 4 spells\n8. Cleric 8: Feat - +2 WIS and Divine Strike\n9. Cleric 9: Mass healing and high-tier utility\n10. Cleric 10: Divine Intervention\n11. Cleric 11: Access to level 6 cleric spells\n12. Cleric 12: Feat - +2 WIS (to 20) or Resilient (CON)\n\nGameplay Loop\nMaintain Bless or Spirit Guardians based on encounter type. Keep allies standing with bonus-action healing while controlling space around your frontline.",
            ],
            [
                'category' => 'character-builds',
                'title'   => 'Thief Rogue Dual Crossbow Level 1-12 Build Guide',
                'content' => "This Rogue build is a high-mobility damage dealer that abuses bonus actions and Sneak Attack consistency from ranged positioning.\n\nCore Setup\n- Class: Rogue (Thief)\n- Key stats: DEX highest, then CON and WIS\n\nLevel Progression (1-12)\n1. Rogue 1: Sneak Attack and key skill proficiencies\n2. Rogue 2: Cunning Action\n3. Rogue 3: Thief for Fast Hands (extra bonus action)\n4. Rogue 4: Feat - Sharpshooter\n5. Rogue 5: Uncanny Dodge\n6. Rogue 6: Expertise upgrades\n7. Rogue 7: Evasion\n8. Rogue 8: Feat - +2 DEX\n9. Rogue 9: Supreme Sneak utility\n10. Rogue 10: Feat - Alert\n11. Rogue 11: Reliable Talent\n12. Rogue 12: Feat - +2 DEX (to 20) or Lucky\n\nGameplay Loop\nOpen from stealth for Sneak Attack, then use dual hand crossbows and extra bonus action shots to keep pressure every round while repositioning safely.",
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
            [
                'category' => 'gameplay-tips',
                'title'   => 'Inventory and Economy Tips for Faster Progress',
                'content' => "Managing loot and gold efficiently makes every act smoother and keeps your party geared without constant backtracking.\n\n1. Send Heavy Loot to Camp\nUse Send to Camp to avoid over-encumbrance while still keeping valuable gear.\n\n2. Sort by Type Before Selling\nGroup junk weapons, armor, and trinkets, then bulk-sell to save time in vendors.\n\n3. Keep Utility Consumables\nDo not sell all scrolls, arrows, and potions. Carry a tactical set for hard fights.\n\n4. Steal Smart, Not Reckless\nUse turn-based mode, line-of-sight checks, and quicksaves before risky pickpocket attempts.\n\n5. Buy Key Power Spikes\nPrioritize strong early upgrades like better bows, +1 weapons, and important scrolls for casters.",
            ],
            [
                'category' => 'gameplay-tips',
                'title'   => 'Combat Positioning Tips That Win Encounters',
                'content' => "In BG3, positioning often matters more than raw stats. Better movement and setup can decide battles before round two.\n\n1. Open From Stealth\nStart encounters with your ranged or burst character to gain early tempo.\n\n2. Hold Choke Points\nFight in doorways and narrow paths to limit enemy numbers.\n\n3. Focus Fire Targets\nEliminate one dangerous enemy at a time instead of spreading damage.\n\n4. Use Vertical Advantage\nRanged attacks from high ground are more accurate and safer.\n\n5. Keep Backline Safe\nPlace casters and supports behind cover and frontliners to avoid sudden dives.",
            ],
            [
                'category' => 'gameplay-tips',
                'title'   => 'Party Setup Tips for Balanced Runs',
                'content' => "A balanced party prevents wipe scenarios and gives you answers for dialogue, exploration, and combat in every zone.\n\n1. Cover Core Roles\nBring one frontliner, one healer or support, one caster, and one flexible damage dealer.\n\n2. Spread Skill Proficiencies\nEnsure your party can handle Persuasion, Sleight of Hand, Perception, and Arcana checks.\n\n3. Prepare for Rest Cycles\nUse short-rest classes and long-rest casters together so your team stays effective between camps.\n\n4. Build Redundancy\nHave at least two characters able to revive, heal, or crowd-control when things go wrong.\n\n5. Adjust Before Bosses\nSwap spells, elixirs, and gear for each major fight instead of using one setup for the whole act.",
            ],
            [
                'category' => 'gameplay-tips',
                'title'   => 'Dialogue and Skill Check Tips for Better Outcomes',
                'content' => "Many of BG3's best rewards come from dialogue choices and skill checks, not just combat wins.\n\n1. Lead with High Charisma\nUse your best Persuasion, Deception, or Intimidation character to start key conversations.\n\n2. Keep Inspiration Ready\nSave Inspiration points for high-impact checks tied to companions, quests, or unique rewards.\n\n3. Use Guidance Constantly\nCast Guidance before social and utility checks whenever possible for easy value.\n\n4. Read NPC Reactions\nIf a conversation turns hostile, back out or change approach before locking into a bad path.\n\n5. Match Skills to Context\nSwap active speaker based on scene: Arcana for magic, Religion for cults, and Insight for suspicious NPCs.",
            ],
            [
                'category' => 'gameplay-tips',
                'title'   => 'Camp, Rest, and Buff Management Tips',
                'content' => "Smart rest timing keeps your party strong and unlocks important story moments with companions.\n\n1. Long Rest Before Big Zones\nEnter major dungeons and boss areas with full spell slots and resources.\n\n2. Do Not Hoard Supplies Forever\nUse camp resources when needed; dead runs cost more than efficient resting.\n\n3. Apply Long-Duration Buffs Early\nCast enduring buffs and summon helpers before triggering long encounters.\n\n4. Check Camp Dialogue Often\nCompanion quests and approvals can advance only when you rest and talk in camp.\n\n5. Reconfigure Spells Between Days\nPrepare spells based on expected fights instead of keeping one static loadout all game.",
            ],
        ];

        foreach ($guides as $data) {
            $category = Category::where('slug', $data['category'])->first();
            if (!$category) continue;

            $guide = Guide::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($data['title'])],
                [
                    'title'       => $data['title'],
                    'content'     => $data['content'],
                    'excerpt'     => null,
                    'category_id' => $category->id,
                    'user_id'     => $admin->id,
                    'status'      => 'published',
                    'featured_image' => $guideMetaByTitle[$data['title']]['featured_image'] ?? null,
                    'views'          => $guideMetaByTitle[$data['title']]['views'] ?? 0,
                ]
            );

            // Keep existing guides in sync with imported SQL metadata/content.
            $guide->fill([
                'title'          => $data['title'],
                'content'        => $data['content'],
                'category_id'    => $category->id,
                'user_id'        => $admin->id,
                'status'         => 'published',
                'featured_image' => $guideMetaByTitle[$data['title']]['featured_image'] ?? null,
                'views'          => $guideMetaByTitle[$data['title']]['views'] ?? 0,
            ]);

            if ($guide->isDirty()) {
                $guide->save();
            }
        }
    }
}
