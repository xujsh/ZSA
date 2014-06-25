//
//  PlayVideoViewController.h
//  teaching
//
//  Created by merlin on 13-12-24.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import "BaseViewController.h"
#import "MediaPlayer/MediaPlayer.h"
#import "CommonViewController.h"

@interface PlayVideoViewController : BaseViewController <UIWebViewDelegate>


@property ( nonatomic , retain) NSURL *playurl;

- (id) initWithUrl:(NSURL *) url;

@end
