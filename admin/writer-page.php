<div class="wrap aimatic-wrap">
    <h1>AIMatic Writer - AI Article Generator & Campaign Manager</h1>
    
    <h2 class="nav-tab-wrapper">
        <a href="#writer" class="nav-tab nav-tab-active" id="tab-writer">Article Writer</a>
        <a href="#campaigns" class="nav-tab" id="tab-campaigns">Auto Campaigns</a>
    </h2>
    
    <div class="aimatic-writer-container">
        
        <!-- WRITER SECTION -->
        <div id="aimatic-writer-section" class="aimatic-section">
            <div class="aimatic-container">
                <div class="aimatic-input-group">
                    <label for="aimatic-topic">Topic / Title:</label>
                    <input type="text" id="aimatic-topic" class="large-text" placeholder="Enter article topic...">
                </div>

                <div class="aimatic-input-group">
                    <label for="aimatic-prompt">Custom Instructions (Optional):</label>
                    <textarea id="aimatic-prompt" class="large-text" rows="3" placeholder="E.g., Tone, style, specific keywords to include..."></textarea>
                </div>

                <div class="aimatic-controls">
                    <button id="aimatic-generate-btn" class="button button-primary button-large">
                        <span class="dashicons dashicons-edit"></span> Write Article
                    </button>
                    <span id="aimatic-status" class="aimatic-status"></span>
                </div>
                
                <div id="aimatic-output-area" class="aimatic-output-area">
                    <label>Live Editor</label>
                    <?php
                    wp_editor('', 'aimatic_editor', array(
                        'textarea_name' => 'aimatic_editor_content',
                        'textarea_rows' => 20,
                        'media_buttons' => true,
                        'wpautop' => false
                    ));
                    ?>
                </div>

                <div class="aimatic-publish-options">
                    <h3>Publish Options</h3>
                    <div style="display:flex; gap:10px; align-items:center; margin-bottom: 10px;">
                        <label for="aimatic-post-status">Status:</label>
                        <select id="aimatic-post-status">
                            <option value="draft">Draft</option>
                            <option value="publish">Publish Immediately</option>
                            <option value="future">Schedule</option>
                        </select>
                        <input type="datetime-local" id="aimatic-schedule-date" style="display:none;">
                    </div>
                    <button id="aimatic-publish-btn" class="button button-primary button-large" style="display:none;">Publish Article</button>
                    <span id="aimatic-publish-message"></span>
                </div>
            </div>
        </div>


        <!-- CAMPAIGNS SECTION -->
        <div id="aimatic-campaigns-section" class="aimatic-section" style="display:none;">
            <div class="aimatic-container">
                <h3>Auto-Blogging Campaigns</h3>
                
                <!-- Cron Integration Helper Removed -->

                <!-- Create Campaign Form -->
                <div class="aimatic-card" style="margin-top: 20px; background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
                    <h2 style="margin-top:0; padding-bottom:10px; border-bottom:1px solid #eee;">Create New Campaign</h2>
                    <div>
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="camp-name">Campaign Name</label></th>
                                <td><input type="text" id="camp-name" class="regular-text" placeholder="e.g. Tech News Daily"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-category">Target Category</label></th>
                                <td>
                                    <?php wp_dropdown_categories(array('id' => 'camp-category', 'hide_empty' => 0, 'show_option_none' => 'Select Category')); ?>
                                    <p class="description">AI will generate topics relevant to this category.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-schedule">Schedule</label></th>
                                <td>
                                    <select id="camp-schedule">
                                        <option value="hourly">Every Hour</option>
                                        <option value="daily">Daily</option>
                                        <option value="twice_daily">Twice Daily</option>
                                        <option value="custom">Custom Minutes</option>
                                    </select>
                                    <div id="camp-custom-container" style="display:none; margin-top:5px;">
                                        <input type="number" id="camp-custom-minutes" class="small-text" value="30" min="1">
                                        <label for="camp-custom-minutes">Minutes</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-posts-per-run">Articles per Interval</label></th>
                                <td>
                                    <input type="number" id="camp-posts-per-run" class="small-text" value="1" min="1" max="10">
                                    <p class="description">How many articles to generate each time the schedule runs.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-status">Status</label></th>
                                <td>
                                    <select id="camp-status-select">
                                        <option value="active">Active</option>
                                        <option value="paused">Paused</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Auto Keywords</th>
                                <td>
                                    <label for="campaign-auto-keywords" style="display:block; margin-bottom:10px;">
                                        <input type="checkbox" id="campaign-auto-keywords" name="campaign_auto_keywords" value="1">
                                    <strong>Auto-Generate Keywords (AI will fetch fresh keywords for each run) OR add manual bulk keywords</strong>
                                </label>
                                <p class="description">Check this to enable automated keyword handling (AI or Bulk File).</p>                           
                                    <!-- Keyword Source Selection -->
                                    <div id="keyword-source-container" style="margin-left: 20px; display:none;">
                                        <p style="margin-bottom:5px; font-weight:600;">Keyword Source:</p>
                                        <label style="margin-right: 15px;">
                                            <input type="radio" name="keyword_source" value="ai" checked> AI Generated
                                        </label>
                                        <label>
                                            <input type="radio" name="keyword_source" value="file"> Bulk List (CSV/TXT)
                                        </label>
                                    </div>

                                    <!-- AI Prompt (Default) -->
                                    <div id="ai-keyword-settings" style="margin-left: 20px; margin-top: 10px;">
                                        <label for="campaign-keyword-prompt" style="display:block; margin-bottom:5px;"><strong>Keyword Strategy Prompt:</strong></label>
                                        <textarea id="campaign-keyword-prompt" class="large-text" rows="2" placeholder="e.g., Generate low-competition long-tail keywords with high search intent.">Generate low-competition, long-tail SEO keywords related to the topic.</textarea>
                                        <p class="description">Define how AI should generate keywords for each article.</p>
                                    </div>

                                    <!-- Bulk Input (Hidden by default) -->
                                    <div id="bulk-keyword-settings" style="margin-left: 20px; margin-top: 10px; display: none;">
                                        
                                        <!-- New: Visual Keyword Manager UI -->
                                        <div id="keyword-manager-ui" style="border: 1px solid #ccd0d4; padding: 15px; background: #fff; border-radius: 4px; margin-bottom: 15px;">
                                            <h4 style="margin-top:0;">Keyword Editor</h4>
                                            
                                            <div style="margin-bottom: 10px;">
                                                <label><strong>Upload File To Append:</strong></label>
                                                <input type="file" id="campaign-bulk-file" accept=".txt,.csv,.xlsx,.xls,.docx,.doc" />
                                            </div>
                                            
                                            <div id="aimatic-visual-editor-container" style="position:relative; margin-top:5px;">
                                                <div id="aimatic-visual-editor" contenteditable="true" style="
                                                    min-height: 200px; 
                                                    max-height: 500px; 
                                                    overflow-y: auto; 
                                                    border: 1px solid #8c8f94; 
                                                    border-radius: 4px; 
                                                    padding: 8px; 
                                                    background: #fff;
                                                    line-height: 1.5;
                                                    font-size: 14px;
                                                "></div>
                                                <textarea id="campaign-bulk-content" name="campaign_bulk_content" style="display:none;"></textarea>
                                            </div>
                                            <p class="description">✅ Green items are completed. Add keywords <strong>one per line</strong> or <strong>separated by commas</strong>.</p>
                                        </div>
                                        <p class="description">Keywords will be processed one by one and removed from this list as articles are generated.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-author">Author</label></th>
                                <td>
                                    <?php wp_dropdown_users(array('name' => 'camp-author', 'id' => 'camp-author', 'who' => 'authors', 'show_option_none' => 'Select Author')); ?>
                                    <p class="description">Assign generated posts to this user.</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Advanced Options</th>
                                <td>
                                    <fieldset>
                                        <label for="camp-internal-links">
                                            <input type="checkbox" id="camp-internal-links" value="1"> Include Internal Links (Contextual)
                                        </label><br>
                                        <label for="camp-outbound-links">
                                            <input type="checkbox" id="camp-outbound-links" value="1"> Include Outbound Links
                                        </label><br>
                                        <label for="camp-read-also">
                                            <input type="checkbox" id="camp-read-also" value="1"> Add "Read Also" Section
                                        </label><br>
                                        <label for="camp-enable-video">
                                            <input type="checkbox" id="camp-enable-video" value="1" checked> Enable YouTube Videos
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-article-style">Article & Blog Style</label></th>
                                <td>
                                    <select id="camp-article-style" class="regular-text">
                                        <option value="generic">Generic (Default)</option>
                                        <option value="how-to">How-To / Tutorial – Step-by-step guides</option>
                                        <option value="listicle">Listicle – “Top 10 / Best Tools” type</option>
                                        <option value="informative">Informative / Educational – Topic explainers</option>
                                        <option value="guide">Guide / Ultimate Guide – Deep, long-form content</option>
                                        <option value="comparison">Comparison Article – “X vs Y” style</option>
                                        <option value="review">Review Article – Product or service review</option>
                                        <option value="trend">Trend Article – Latest updates/news</option>
                                        <option value="case-study">Case Study / Success Story – Real results</option>
                                        <option value="editorial">Opinion / Editorial – Expert thoughts</option>
                                        <option value="faq">FAQ Article – Quick-answer format</option>
                                    </select>
                                    <p class="description">Select the structure/style for your articles (Best for SEO + Readers).</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="camp-prompts">Article Custom Prompt</label></th>
                                <td>
                                    <textarea id="camp-prompts" class="regular-text" rows="4" placeholder="e.g., Write in a friendly, conversational tone. Use short paragraphs..."></textarea>
                                    <p class="description">Custom instructions (tone, rules) to append to the selected style.</p>
                                </td>
                            </tr>
                        </table>
                        <p class="submit">
                            <button id="btn-save-campaign" class="button button-primary">Save Campaign</button>
                            <span id="camp-status" style="margin-left: 10px; font-weight: bold;"></span>
                        </p>
                    </div>
                </div>

                <!-- Existing Campaigns List -->
                <h2 style="margin-top: 30px;">Active Campaigns</h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Campaign Name</th>
                            <th>Category</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Last Run</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="campaign-list-body">
                        <?php
                        $campaigns_handler = new AIMatic_Campaigns();
                        $campaigns = $campaigns_handler->get_campaigns();

                        if (empty($campaigns)) {
                            echo '<tr><td colspan="6">No campaigns found. Create one above!</td></tr>';
                        } else {
                            foreach ($campaigns as $id => $campaign) {
                                // Ensure ID is available
                                if (!isset($campaign['id'])) $campaign['id'] = $id;
                                
                                // Robust Category handling
                                $cat_id = isset($campaign['category_id']) ? $campaign['category_id'] : 0;
                                $cat = get_category($cat_id);
                                if (is_wp_error($cat) || !$cat) {
                                    $cat_name = 'Unknown';
                                } else {
                                    $cat_name = $cat->name;
                                }
                                $last_run_timestamp = isset($campaign['last_run']) ? $campaign['last_run'] : 0;
                                $last_run = $last_run_timestamp ? date('Y-m-d H:i:s', $last_run_timestamp) : 'Never';
                                $camp_status = isset($campaign['status']) ? $campaign['status'] : 'paused';
                                $status_icon = $camp_status === 'active' ? '✅' : '⏸️';
                                $schedule_label = ucfirst(str_replace('_', ' ', $campaign['schedule']));
                                
                                // Safe values for attributes
                                $prompts_attr = isset($campaign['prompts']) ? esc_attr($campaign['prompts']) : '';
                                $kw_prompt_attr = isset($campaign['keyword_prompt']) ? esc_attr($campaign['keyword_prompt']) : '';
                                $auto_kw_attr = isset($campaign['auto_keywords']) ? $campaign['auto_keywords'] : 0;
                                $posts_per_run_attr = isset($campaign['posts_per_run']) ? intval($campaign['posts_per_run']) : 1;
                                
                                // Preload Keywords (DB Source)
                                $keywords_list = isset($campaign['keywords_list']) ? $campaign['keywords_list'] : array();
                                
                                // Backward Compat: Check legacy file if DB empty
                                if (empty($keywords_list)) { 
                                     $upload_dir = wp_upload_dir();
                                     $queue_path = $upload_dir['basedir'] . '/aimatic-campaigns/keywords-' . $campaign['id'] . '.queue';
                                     if (file_exists($queue_path)) {
                                         $kws = file($queue_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                                         if ($kws) $keywords_list = array_slice($kws, 0, 500); // Migration will happen on next save
                                     }
                                }
                                
                                // Use JSON for robustness against attribute whitespace normalization
                                $keywords_json = json_encode($keywords_list);
                            ?>
                            <tr id="campaign-<?php echo esc_attr($campaign['id']); ?>">
                                <td><strong><?php echo esc_html($campaign['name']); ?></strong></td>
                                <td><?php echo esc_html($cat_name); ?></td>
                                <td><?php echo esc_html($schedule_label); ?></td>
                                <td>
                                    <?php if ($camp_status === 'active'): ?>
                                        <span style="color: green;">● Active</span>
                                    <?php else: ?>
                                        <span style="color: gray;">● Paused</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($last_run); ?></td>
                                <td>
                                    <button class="button btn-run-campaign" data-id="<?php echo esc_attr($campaign['id']); ?>" data-original-text="Run Now">Run Now</button>
                                    <button class="button btn-edit-campaign" 
                                            data-id="<?php echo esc_attr($campaign['id']); ?>"
                                            data-name="<?php echo esc_attr($campaign['name']); ?>"
                                            data-keywords-json="<?php echo esc_attr($keywords_json); ?>"
                                            data-category="<?php echo esc_attr(isset($campaign['category_id']) ? $campaign['category_id'] : ''); ?>"
                                            data-schedule="<?php echo esc_attr($campaign['schedule']); ?>"
                                            data-custom-minutes="<?php echo isset($campaign['custom_schedule_minutes']) ? esc_attr($campaign['custom_schedule_minutes']) : '60'; ?>"
                                            data-posts-per-run="<?php echo $posts_per_run_attr; ?>"
                                            data-status="<?php echo esc_attr($camp_status); ?>"
                                            data-prompts="<?php echo $prompts_attr; ?>"
                                            data-article-style="<?php echo isset($campaign['article_style']) ? esc_attr($campaign['article_style']) : 'generic'; ?>"
                                            data-auto-kw="<?php echo $auto_kw_attr; ?>"
                                            data-keyword-source="<?php echo isset($campaign['keyword_source']) ? esc_attr($campaign['keyword_source']) : 'ai'; ?>"
                                            data-kw-prompt="<?php echo $kw_prompt_attr; ?>"
                                            data-author="<?php echo isset($campaign['author_id']) ? esc_attr($campaign['author_id']) : ''; ?>"
                                            data-internal-links="<?php echo isset($campaign['internal_links']) ? esc_attr($campaign['internal_links']) : 0; ?>"
                                            data-outbound-links="<?php echo isset($campaign['outbound_links']) ? esc_attr($campaign['outbound_links']) : 0; ?>"
                                            data-read-also="<?php echo isset($campaign['read_also']) ? esc_attr($campaign['read_also']) : 0; ?>"
                                            data-enable-video="<?php echo isset($campaign['enable_video']) ? esc_attr($campaign['enable_video']) : 0; ?>"
                                    >Edit</button>
                                    <button class="button btn-delete-campaign" data-id="<?php echo esc_attr($campaign['id']); ?>" style="color: #b32d2e; border-color: #b32d2e;">Delete</button>
                                </td>
                            </tr>
                            <?php 
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Image Progress Modal -->
        <div id="aimatic-image-progress-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:white; padding:30px; border-radius:8px; max-width:500px; width:90%; box-shadow:0 4px 20px rgba(0,0,0,0.3);">
                <h2 style="margin:0 0 20px 0; color:#333;">📸 Processing Images</h2>
                <div id="aimatic-progress-content" style="font-size:14px; color:#666; line-height:1.8; max-height: 200px; overflow-y: auto;">
                    <p>⏳ Starting image processing...</p>
                </div>
                <div style="margin-top:20px; background:#f0f0f0; border-radius:4px; height:8px; overflow:hidden;">
                    <div id="aimatic-progress-bar" style="background:#0073aa; height:100%; width:0%; transition:width 0.3s;"></div>
                </div>
                <p id="aimatic-progress-percent" style="text-align:center; margin:10px 0 0 0; font-weight:bold; color:#0073aa;">0%</p>
            </div>
        </div>

    </div>
</div>
