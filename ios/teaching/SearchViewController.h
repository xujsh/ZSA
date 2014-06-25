//
//  SearchViewController.h
//  teaching
//
//  Created by kidliuxu on 14-4-16.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "BaseViewController.h"
#import "CommonViewController.h"

@interface SearchViewController : BaseViewController <UITextFieldDelegate>

@property ( nonatomic , retain) NSURL *courseUrl;
@property (nonatomic, retain)UITextField *inputView;

- (id) initWithUrl:(NSURL *) url;

@end
